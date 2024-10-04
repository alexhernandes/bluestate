<?php

namespace App\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use GuzzleHttp\Client;

class Payment extends BaseController
{
    public function mercadopago($status)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        if ($status == "callback") {
            exit;
            \MercadoPago\MercadoPagoConfig::setAccessToken(getenv('MERCADOPAGO_ACCESS_TOKEN'));

            $body = file_get_contents('php://input');
            $data = json_decode($body);

            if (isset($data->data->id)) {
                $paymentId = $data->data->id;

                try {
                    $client = new \MercadoPago\Client\Payment\PaymentClient();
                    $payment = $client->get($paymentId);

                    $status = $payment->status;
                    $externalReference = $payment->external_reference;

                    log_message('info', "Pagamento MercadoPago confirmado: ID: $paymentId, Status: $status, Referência Externa: $externalReference");

                    echo "Pagamento confirmado: ID: $paymentId, Status: $status, Referência Externa: $externalReference";
                } catch (\Exception $e) {
                    log_message('error', 'Erro ao processar notificação do MercadoPago: ' . $e->getMessage());
                    http_response_code(400);
                    exit();
                }
            } else {
                http_response_code(400);
                echo 'ID de pagamento não fornecido';
                exit();
            }

            http_response_code(200);
        } else {
            // ?collection_id=1319765622&collection_status=approved&payment_id=1319765622&status=approved&external_reference=4138152&payment_type=credit_card&merchant_order_id=23403110079&preference_id=78384737-ade71565-242f-487e-aea1-f9dc6688e843&site_id=MLB&processing_mode=aggregator&merchant_account_id=null
            $queryString = $request->getServer('QUERY_STRING');
            $queryArray  = [];

            parse_str($queryString, $queryArray);
            $unicoId = $queryArray["external_reference"];

            // PAGAMENTO
            // ============================
            $data_pagamento["pagamento_UnicoID"]                  = $unicoId;
            $data_pagamento["pagamento_Plataforma_OrderID"]       = $queryArray["merchant_order_id"];
            $data_pagamento["pagamento_Plataforma_IntentID"]      = $queryArray["collection_id"];
            $data_pagamento["pagamento_Plataforma_PaymentID"]     = $queryArray["payment_id"];
            $data_pagamento["pagamento_Plataforma_TipoPagamento"] = $queryArray["payment_type"];
            $data_pagamento["pagamento_Plataforma_Status"]        = $queryArray["status"];
            $data_pagamento["pagamento_Plataforma_JsonIntent"]    = json_encode($queryArray);
            $data_pagamento["pagamento_Status"]                   = 2; //Pagamento realizado
            $data_pagamento["pagamento_UltimaAtualizacao"]        = date('Y-m-d H:i:s');
            $this->update($unicoId, $data_pagamento);

            if ($status == "success") {
                return redirect()->to("payment/success/" . $unicoId);
            } elseif ($status == "cancel") {
                return redirect()->to("payment/cancel/" . $unicoId);
            } elseif ($status == "pending") {
                return redirect()->to("payment/pending/" . $unicoId);
            }
        }
    }

    public function stripe()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        $sessionId = $request->getGet('session_id');

        if ($sessionId) {
            try {
                $session = \Stripe\Checkout\Session::retrieve($sessionId);
                $unicoId = $session->client_reference_id;

                $paymentIntentId = $session->payment_intent;
                $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

                $paymentMethodId = $paymentIntent->payment_method;
                $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);

                $paymentIntent      = substr($paymentIntent, stripos($paymentIntent, '{'));
                $paymentMethod      = substr($paymentMethod, stripos($paymentMethod, '{'));
                $paymentIntentArray = json_decode($paymentIntent, true);
                $paymentMethodArray = json_decode($paymentMethod, true);

                // PAGAMENTO
                // ============================
                $data_pagamento["pagamento_UnicoID"]                  = $unicoId;
                $data_pagamento["pagamento_Plataforma_OrderID"]       = $unicoId;
                $data_pagamento["pagamento_Plataforma_IntentID"]      = $paymentIntentId;
                $data_pagamento["pagamento_Plataforma_PaymentID"]     = $paymentMethodArray['id'];
                $data_pagamento["pagamento_Plataforma_Valor"]         = $paymentIntentArray['amount_received'];
                $data_pagamento["pagamento_Plataforma_Moeda"]         = $paymentIntentArray['currency'];
                $data_pagamento["pagamento_Plataforma_TipoPagamento"] = $paymentMethodArray['type'];
                $data_pagamento["pagamento_Plataforma_Status"]        = $paymentIntentArray['status'];
                $data_pagamento["pagamento_Plataforma_Country"]       = $paymentMethodArray['card']['country'];
                $data_pagamento["pagamento_Plataforma_JsonIntent"]    = $paymentIntent;
                $data_pagamento["pagamento_Plataforma_JsonMethod"]    = $paymentMethod;
                $data_pagamento["pagamento_Plataforma_JsonSession"]   = $session;
                $data_pagamento["pagamento_Status"]                   = 2; //Pagamento realizado
                $data_pagamento["pagamento_UltimaAtualizacao"]        = date('Y-m-d H:i:s');
                $this->update($unicoId, $data_pagamento);

                $status = $data_pagamento["pagamento_Plataforma_Status"];
                if ($status == "succeeded") {
                    return redirect()->to("payment/success/" . $unicoId);
                } elseif ($status == "canceled") {
                    return redirect()->to("payment/cancel/" . $unicoId);
                } elseif ($status == "processing") {
                    return redirect()->to("payment/pending/" . $unicoId);
                }
            } catch (\Exception $e) {
                echo 'Erro ao processar o pagamento: ' . $e->getMessage();
            }
        } else {
            echo 'Session ID não fornecido.';
        }
    }

    public function update($unicoId, $data)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $PagamentoModel = new \App\Models\PagamentoModel();
        $ContadorModel  = new \App\Models\ContadorModel();
        $EmailModel     = new \App\Models\EmailModel();
        $UsuarioModel   = new \App\Models\UsuarioModel();

        $locale = $request->getLocale();
        $languages = [
            'pt' => 'Português Brasileiro',
            'es' => 'Espanhol',
            'en' => 'Inglês'
        ];

        $PagamentoModel
            ->where('pagamento_UnicoID', $unicoId)
            ->set($data)
            ->update();

        $contador = $ContadorModel
            ->where("contador_UnicoID", $unicoId)
            ->first();

        $usuario = $UsuarioModel
            ->where("usuario_UsuarioID", $contador->contador_UsuarioID)
            ->first();

        if ($contador) {
            $prompt = '
                A resposta deve obrigatóriamente ser respondida em: ' . ($languages[$locale] ?? 'Idioma desconhecido') . '.
                Hora da viagem: ' . $contador->contador_HoraObjetivo . '.
                Data da viagem: ' . $contador->contador_DataObjetivo . '.
                Titulo: ' . $contador->contador_Titulo . '.
                Descrição: ' . $contador->contador_Descricao . '.
                Você é um especiliasta em viagens e em criar roteiros.
                Crie um roteiro de 5 dias.
                Com atrações turísticas icônicas, locais menos conhecidos, atividades culturais e gastronomia.
                Pelo titulo e descrição tente descobrir ao máximo o destino dessa viagem.
                Se você não identificar o destino, apenas retorne a mensagem: "Não consegui encontrar o destino, que tal nos dar mais informações?".
                Jamais invente lugares que não existem.
            ';

            $data_contador["contador_Itinerario"]   = $this->gerar_itinerario($prompt);
            $data_contador["contador_QRCode"]       = $this->gerar_qrcode($unicoId, $contador->contador_Slug);
            $data_contador["contador_Status"]       = 2;

            $ContadorModel
                ->where('contador_UnicoID', $unicoId)
                ->set($data_contador)
                ->update();

            // EMAIL
            // ============================
            $data_email["email_UsuarioID"] = $usuario->usuario_UsuarioID;
            $data_email["email_Para"]      = $usuario->usuario_Email;
            $data_email["email_Assunto"]   = "Seu pagamento foi efetuado com sucesso";
            $data_email["email_Email"]     = "Olá, tudo bem?<br/>O seu pagamento foi feito com sucesso.<br/>O endereço do seu site é: " . base_url("view/" . $contador->contador_Slug);;
            $data_email["email_Status"]    = 1;
            $data_email["email_DataHora"]  = date('Y-m-d H:i:s');;
            $EmailModel->insert($data_email);
        }
    }

    public function gerar_qrcode($unicoId, $slug)
    {
        $url = base_url() . 'view/' . $slug;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($url)
            ->size(300)
            ->margin(10)
            ->build();

        return base64_encode($result->getString());
    }

    public function gerar_itinerario($prompt)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . getenv('OPENAI_TOKEN'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    // [
                    //     'role' => 'system',
                    //     'content' => $prompt
                    // ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                // 'max_tokens' => 300, // Defina o número máximo de tokens que deseja receber
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        $itinerary = $result['choices'][0]['message']['content'] ?? 'Nenhum itinerário gerado.';

        return $itinerary;
    }

    public function success($unicoId)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $ContadorModel = new \App\Models\ContadorModel();

        $contador = $ContadorModel
            ->where("contador_UnicoID", $unicoId)
            ->first();

        $data["page_title"]    = lang('Payment.success.title');
        $data["page_subtitle"] = lang('Payment.success.subtitle');
        $data["page_link"]     = lang('Payment.success.link');
        $data["page_button"]   = lang('Payment.success.button');
        $data["page_url"]      = base_url("view/" . $contador->contador_Slug);
        $data["page_qrcode"]   = "data:image/png;base64," . $contador->contador_QRCode;

        $session->set('site_title', lang('Page.site_title'));
        $session->set('site_description', lang('Page.site_description'));

        // $cachePage(60, true, 'minha_pagina_cache-'. $session->get('lang'));
        return view('payment', $data);
    }

    public function pending()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $data["page_title"]    = lang('Payment.pending.title');
        $data["page_subtitle"] = lang('Payment.pending.subtitle');
        $data["page_button"]   = false;
        $data["page_url"]      = false;
        $data["page_qrcode"]   = false;

        $session->set('site_title', lang('Page.site_title'));
        $session->set('site_description', lang('Page.site_description'));

        // $this->cachePage(3600);
        return view('payment', $data);
    }

    public function error()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $data["page_title"]    = lang('Payment.error.title');
        $data["page_subtitle"] = lang('Payment.error.subtitle');
        $data["page_button"]   = false;
        $data["page_url"]      = false;
        $data["page_qrcode"]   = false;

        $session->set('site_title', lang('Page.site_title'));
        $session->set('site_description', lang('Page.site_description'));

        // $this->cachePage(3600);
        return view('payment', $data);
    }
}
