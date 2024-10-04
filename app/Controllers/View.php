<?php

namespace App\Controllers;

class View extends BaseController
{
    public function index($slug)
    {
        // - Fazer a verificacao de tempo e bloquear acesso
        // - Fazer a verificacao de tempo e bloquear acesso
        // - Fazer a verificacao de tempo e bloquear acesso
        // - Fazer a verificacao de tempo e bloquear acesso
        // - Fazer a verificacao de tempo e bloquear acesso
        // - Fazer a verificacao de tempo e bloquear acesso
        // - Fazer a verificacao de tempo e bloquear acesso

        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $ContadorModel = new \App\Models\ContadorModel();
        $FotoModel     = new \App\Models\FotoModel();

        $data["contador"] = $ContadorModel
            ->where("contador_Slug", $slug)
            ->first();

        if(!$data["contador"]) return redirect()->to("/");

        $data["foto"] = $FotoModel
            ->where("foto_UnicoID", $data["contador"]->contador_UnicoID)
            ->findAll();

        $dataHoraAlvo     = $data["contador"]->contador_DataObjetivo . ' ' . $data["contador"]->contador_HoraObjetivo;
        $dataHoraAtual    = new \DateTime();
        $dataHoraObjetivo = new \DateTime($dataHoraAlvo);
        $intervalo        = $dataHoraAtual->diff($dataHoraObjetivo);
        $locale           = $request->getLocale();
        $data["passed"]   = false;

        if ($dataHoraObjetivo > $dataHoraAtual) {
            $anos = $intervalo->y;
            $meses = $intervalo->m;
            $dias = $intervalo->d;
            $horas = $intervalo->h;
            $minutos = $intervalo->i;
            $segundos = $intervalo->s;

            $data["titulo"] = '';

            if ($anos >= 1) {
                $data["titulo"] = lang('View.remain', [$anos, lang("View.year") . ($anos > 1 ? 's' : '')]);
            }
            elseif ($meses >= 1) {
                $data["titulo"] = lang('View.remain', [$meses + $anos * 12, lang("View.month") . ($meses > 1 ? ($locale == 'es' || $locale == 'pt' ? 'es' : 's') : '')]);
            }
            elseif ($dias >= 1) {
                $data["titulo"] = lang('View.remain', [$dias, lang("View.day") . ($dias > 1 ? 's' : '')]);
            }
            elseif ($horas >= 1) {
                $data["titulo"] = lang('View.remain', [$horas, lang("View.hour") . ($horas > 1 ? 's' : '')]);
            }
            elseif ($minutos >= 1) {
                $data["titulo"] = lang('View.remain', [$minutos, lang("View.minute") . ($minutos > 1 ? 's' : '')]);
            }
            else {
                $segundos = $intervalo->s;
                $data["titulo"] = lang('View.remain', [$segundos, lang("View.second") . ($segundos > 1 ? 's' : '')]);
            }
        } else {
            $data["titulo"] = lang('View.passed');
            $data["passed"] = true;
        }

        $titulo_tratado = $data["titulo"];
        $titulo_tratado = str_replace('<span class="conteudo__chamada-degrade">', '', $titulo_tratado);
        $titulo_tratado = str_replace('</span>', '', $titulo_tratado);
        $titulo_tratado = $titulo_tratado . " - toloov";

        $session->set('site_title', $titulo_tratado);
        $session->set('site_description', $titulo_tratado);

        return view('view', $data);
    }
}