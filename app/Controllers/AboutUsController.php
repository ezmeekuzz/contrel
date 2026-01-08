<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AboutUsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel Elettronica - Electronic Devices for Electrical Measurement and Protection',
            'banner' => '/images/about-us-banner.png',
            'h1Tag' => 'About Us',
            'dnone' => 'display: none !important;',
            'columnSize' => 'col-lg-5'
        ];

        return view('pages/about-us', $data);
    }
}
