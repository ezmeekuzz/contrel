<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel Elettronica - Electronic Devices for Electrical Measurement and Protection',
            'banner' => '/images/hero-bg.png',
            'h1Tag' => 'Electronic Devices for Electrical Measurement and Protection',
            'dnone' => '',
            'columnSize' => 'col-lg-5'
        ];

        return view('pages/home', $data);
    }
}
