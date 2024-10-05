<?php
namespace App\Controllers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Home extends BaseController
{
    public function index($locale = ''): string
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $email   = \Config\Services::email();

        $availableLocales = ['pt', 'en', 'es'];
        if (in_array($locale, $availableLocales)) {
            $session->set('lang', $locale);
            $request->setLocale($locale);
        }

        echo '<h2>Informações do Servidor</h2>';
        echo '<ul>';
        echo '<li>Versão do PHP: ' . phpversion() . '</li>';
        echo '<li>Software do Servidor: ' . $_SERVER['SERVER_SOFTWARE'] . '</li>';
        echo '<li>Endereço IP: ' . $_SERVER['SERVER_ADDR'] . '</li>';
        echo '<li>Nome do Host: ' . gethostname() . '</li>';
        echo '</ul>';

        $session->set('site_title', lang('Home.site_title'));
        $session->set('site_description', lang('Home.site_description'));

        return view('home');
    }
}
