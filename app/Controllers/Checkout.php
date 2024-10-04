<?php
namespace App\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class Checkout extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        $unicoId = unicoId();
        $files   = $request->getFiles();
        $post    = $request->getPost();
        $price   = $this->getPrice($post);
        $fotos   = $this->upload($unicoId, $files);

        if ($request->getLocale() == "pt") {
            $this->save($unicoId, $post, $fotos, $price, "mercadopago");
            return $this->mercadopago($unicoId, $price, $post);
        } elseif ($request->getLocale() == "en") {
            $this->save($unicoId, $post, $fotos, $price, "stripe");
            return $this->stripe($unicoId, $price, $post);
        } elseif ($request->getLocale() == "es") {
            $this->save($unicoId, $post, $fotos, $price, "stripe");
            return $this->stripe($unicoId, $price, $post);
        }
    }

    public function getPrice($post)
    {
        $selectedPlan = $post["plan"];
        $options = lang('Modal.form.plan.option');

        foreach ($options as $option) {
            if ($option["value"] === $selectedPlan) {
                return $option;
                break;
            }
        }
    }

    public function upload($unicoId, $files)
    {
        if ($files && isset($files['photo'])) {
            $uploadPath = ROOTPATH . 'public/assets/uploads/' . $unicoId . '/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);  // Cria a pasta se não existir
            }

            $uploadedImages = [];

            foreach ($files['photo'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);
                    $uploadedImages[] = $newName;
                } else {
                    // return "Erro ao enviar o arquivo: " . $file->getErrorString();
                    return false;
                }
            }

            return $uploadedImages;
        } else {
            return false;
            // return "Nenhum arquivo foi enviado.";
        }
    }

    public function save($unicoId, $post, $fotos, $price, $plataforma)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $ContadorModel  = new \App\Models\ContadorModel();
        $FotoModel      = new \App\Models\FotoModel();
        $PagamentoModel = new \App\Models\PagamentoModel();
        $UsuarioModel   = new \App\Models\UsuarioModel();
        $EmailModel     = new \App\Models\EmailModel();

        // USUARIO
        // ============================
        $usuario = $UsuarioModel
            ->where("usuario_Email", $post["email"])
            ->first();

        if ($usuario) {
            $last__UsuarioID = $usuario->usuario_UsuarioID;
        } else {
            $data_usuario["usuario_NomeCompleto"] = "";
            $data_usuario["usuario_Email"]        = $post["email"];
            $data_usuario["usuario_Telefone"]     = "";
            $data_usuario["usuario_Code"]         = "";
            $data_usuario["usuario_Status"]       = 1;
            $data_usuario["usuario_DataHora"]     = date('Y-m-d H:i:s');

            $UsuarioModel->insert($data_usuario);
            $last__UsuarioID = $UsuarioModel->insertID();
        }

        // PAGAMENTO
        // ============================
        $data_pagamento["pagamento_UsuarioID"]                = $last__UsuarioID;
        $data_pagamento["pagamento_UnicoID"]                  = $unicoId;
        $data_pagamento["pagamento_Identificador"]            = "";
        $data_pagamento["pagamento_Tipo"]                     = "";
        $data_pagamento["pagamento_Valor"]                    = $price['money'];
        $data_pagamento["pagamento_Moeda"]                    = $price['currency'];
        $data_pagamento["pagamento_Plataforma"]               = $plataforma;
        $data_pagamento["pagamento_Plataforma_OrderID"]       = "";
        $data_pagamento["pagamento_Plataforma_IntentID"]      = "";
        $data_pagamento["pagamento_Plataforma_PaymentID"]     = "";
        $data_pagamento["pagamento_Plataforma_Valor"]         = "";
        $data_pagamento["pagamento_Plataforma_Moeda"]         = "";
        $data_pagamento["pagamento_Plataforma_TipoPagamento"] = "";
        $data_pagamento["pagamento_Plataforma_Status"]        = "";
        $data_pagamento["pagamento_Plataforma_Country"]       = $request->getLocale();
        $data_pagamento["pagamento_Plataforma_JsonIntent"]    = "";
        $data_pagamento["pagamento_Plataforma_JsonMethod"]    = "";
        $data_pagamento["pagamento_Plataforma_JsonSession"]   = "";
        $data_pagamento["pagamento_Status"]                   = 1;
        $data_pagamento["pagamento_UltimaAtualizacao"]        = date('Y-m-d H:i:s');
        $data_pagamento["pagamento_DataHora"]                 = date('Y-m-d H:i:s');

        $PagamentoModel->insert($data_pagamento);
        $last__PagamentoID = $PagamentoModel->insertID();

        // CONTADOR
        // ============================
        $data_contador["contador_UnicoID"]      = $unicoId;
        $data_contador["contador_UsuarioID"]    = $last__UsuarioID;
        $data_contador["contador_PagamentoID"]  = $last__PagamentoID;
        $data_contador["contador_Slug"]         = gerarId();
        $data_contador["contador_DataObjetivo"] = $post["date"];
        $data_contador["contador_HoraObjetivo"] = $post["time"];
        $data_contador["contador_Titulo"]       = $post["titulo"];
        $data_contador["contador_Descricao"]    = $post["description"];
        $data_contador["contador_Itinerario"]   = "";
        $data_contador["contador_Plano"]        = $post["plan"];
        $data_contador["contador_QRCode"]       = "";
        $data_contador["contador_Status"]       = 1;
        $data_contador["contador_DataHora"]     = date('Y-m-d H:i:s');

        $ContadorModel->insert($data_contador);
        $last__ContadorID = $ContadorModel->insertID();

        // FOTOS
        // ============================
        foreach ($fotos as $item) {
            $data_foto["foto_ContadorID"] = $last__ContadorID;
            $data_foto["foto_UnicoID"]    = $unicoId;
            $data_foto["foto_Foto"]       = $item;
            $data_foto["foto_Completo"]   = 'assets/uploads/' . $unicoId . '/' . $item;
            $data_foto["foto_Status"]     = 1;
            $data_foto["foto_DataHora"]   = date('Y-m-d H:i:s');
            $FotoModel->insert($data_foto);
        }

        // EMAIL
        // ============================
        $data_email["email_UsuarioID"] = $last__UsuarioID;
        $data_email["email_Para"]      = $post["email"];
        $data_email["email_Assunto"]   = "Recebemos o seu pedido";
        $data_email["email_Email"]     = "Olá, tudo bem?<br/>Recebemos o seu pedido, agora vamos processar o seu pagamentos, pode ficar tranquilo que vamos avisando tudo por aqui.";
        $data_email["email_Status"]    = 1;
        $data_email["email_DataHora"]  = date('Y-m-d H:i:s');;
        $EmailModel->insert($data_email);
    }

    public function mercadopago($unicoId, $price, $post)
    {
        MercadoPagoConfig::setAccessToken(getenv('MERCADOPAGO_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $client = new PreferenceClient();

        $preference = $client->create([
            "external_reference"        => $unicoId,
            "notification_url"          => base_url() . "payment/mercadopago/callback",
            "auto_return"               => "all",
            "default_payment_method_id" => "master",
            "statement_descriptor"      => "MEUNEGOCIO",
            "installments"              => 12,
            "default_installments"      => 1,
            "payer" => array(
                "email" => $post["email"],
            ),
            "back_urls" => array(
                "success" => base_url() . "payment/mercadopago/success",
                "cancel"  => base_url() . "payment/mercadopago/cancel",
                "pending" => base_url() . "payment/mercadopago/pending",
            ),
            "items" => array(
                array(
                    "id"          => "4567",
                    "title"       => $price['title'],
                    "description" => $price['title'],
                    "picture_url" => "http://www.myapp.com/myimage.jpg",
                    "category_id" => "eletronico",
                    "quantity"    => 1,
                    "currency_id" => $price['currency'],
                    "unit_price" => floatval($price['money'])
                )
            )
        ]);

        return redirect()->to($preference->init_point);
    }

    public function stripe($unicoId, $price, $post)
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'client_reference_id'  => $unicoId,
            'mode'                 => 'payment',
            'success_url'          => base_url('/payment/stripe/callback') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => base_url('/payment/cancel'),
            'line_items' => [[
                'price_data' => [
                    'currency'    => $price['currency'],
                    'unit_amount' => intval(floatval($price['money']) * 100),
                    'product_data' => [
                        'name' => $price['title'],
                    ],
                ],
                'quantity' => 1,
            ]],
        ]);

        return redirect()->to($session->url)->send();
    }
}
