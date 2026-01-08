<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PrivacyPolicyController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel Elettronica - Electronic Devices for Electrical Measurement and Protection',
            'banner' => '/images/hero-bg.png',
            'h1Tag' => 'Privacy Policy',
            'dnone' => 'display: none !important;',
            'columnSize' => 'col-lg-5'
        ];

        return view('pages/privacy-policy', $data);
    }
}
