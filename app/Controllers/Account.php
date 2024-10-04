<?php

namespace App\Controllers;

class Account extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $session->set('site_title', lang('Account.site_title'));
        $session->set('site_description', lang('Account.site_description'));

        return view('account');
    }

    public function send()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $PagamentoModel = new \App\Models\PagamentoModel();
        $ContadorModel  = new \App\Models\ContadorModel();
        $EmailModel     = new \App\Models\EmailModel();
        $UsuarioModel   = new \App\Models\UsuarioModel();

        $usuario = $UsuarioModel
            ->where("usuario_Email", $request->getPost("email"))
            ->first();

        if ($usuario) {
            $data_usuario["usuario_Code"] = rand(000001, 999999);

            $UsuarioModel
                ->where('usuario_UsuarioID', $usuario->usuario_UsuarioID)
                ->set($data_usuario)
                ->update();

            // EMAIL
            // ============================
            $data_email["email_UsuarioID"] = $usuario->usuario_UsuarioID;
            $data_email["email_Para"]      = $usuario->usuario_Email;
            $data_email["email_Assunto"]   = "Chegou o seu código de acesso";
            $data_email["email_Email"]     = "Olá, tudo bem?<br/>Aqui está o seu código de acesso:.<br/>" . $data_usuario["usuario_Code"];
            $data_email["email_Status"]    = 1;
            $data_email["email_DataHora"]  = date('Y-m-d H:i:s');;
            $EmailModel->insert($data_email);

            return 'true';
        } else {
            return 'false';
        }
    }

    public function verify()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $PagamentoModel = new \App\Models\PagamentoModel();
        $ContadorModel  = new \App\Models\ContadorModel();
        $EmailModel     = new \App\Models\EmailModel();
        $UsuarioModel   = new \App\Models\UsuarioModel();

        $email = $request->getPost("email");
        $code  = $request->getPost("code");

        if ($code == 0) {
            exit;
        }

        $usuario = $UsuarioModel
            ->where("usuario_Email", $email)
            ->where("usuario_Code", $code)
            ->first();

        if ($usuario) {
            $data_usuario["usuario_Code"] = 0;

            $UsuarioModel
                ->where('usuario_UsuarioID', $usuario->usuario_UsuarioID)
                ->set($data_usuario)
                ->update();

            $session->set('login_logado', true);
            $session->set('login_usuarioid', $usuario);

            return redirect()->to("account/list/");
        } else {
            return redirect()->to("account");
        }
    }

    public function list()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $PagamentoModel = new \App\Models\PagamentoModel();
        $ContadorModel  = new \App\Models\ContadorModel();
        $EmailModel     = new \App\Models\EmailModel();
        $UsuarioModel   = new \App\Models\UsuarioModel();

        if ($session->get('login_logado') != true) return redirect()->to("account");

        $data["contador"] = $ContadorModel
            ->join('pagamento', 'pagamento.pagamento_PagamentoID = contador.contador_PagamentoID', 'left')
            ->where("contador_UsuarioID", $session->get('login_usuarioid')->usuario_UsuarioID)
            ->findAll();

        $session->set('site_title', lang('Account.site_title'));
        $session->set('site_description', lang('Account.site_description'));

        return view('account-list', $data);
    }

    public function code($slug)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $ContadorModel = new \App\Models\ContadorModel();
        $FotoModel     = new \App\Models\FotoModel();

        $data["contador"] = $ContadorModel
            ->where("contador_Slug", $slug)
            ->first();

        echo '<img src="data:image/png;base64,' . $data["contador"]->contador_QRCode .'" style="width: 300px;">';
    }
}
