<?php
namespace App\Controllers;

class Page extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $PagamentoModel = new \App\Models\PagamentoModel();
        $ContadorModel  = new \App\Models\ContadorModel();
        $EmailModel     = new \App\Models\EmailModel();
        $UsuarioModel   = new \App\Models\UsuarioModel();

        $PageModel = new \App\Models\PageModel();

        $data["page"] = $PageModel
            ->where("pagina_Status", "1")
            ->findAll();

        $session->set('site_title', lang('Page.site_title'));
        $session->set('site_description', lang('Page.site_description'));

        return view('page', $data);
    }

    public function view($slug)
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $PagamentoModel = new \App\Models\PagamentoModel();
        $ContadorModel  = new \App\Models\ContadorModel();
        $EmailModel     = new \App\Models\EmailModel();
        $UsuarioModel   = new \App\Models\UsuarioModel();

        $PageModel = new \App\Models\PageModel();

        $data["page"] = $PageModel
            ->where("pagina_Slug", $slug)
            ->where("pagina_Status", "1")
            ->first();

        $session->set('site_title', lang('Page.site_title'));
        $session->set('site_description', lang('Page.site_description'));

        return view('page-view', $data);
    }
}
