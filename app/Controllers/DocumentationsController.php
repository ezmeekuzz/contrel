<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DocumentationsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel Elettronica - Electronic Devices for Electrical Measurement and Protection',
            'banner' => '/images/documentation-banner.png',
            'h1Tag' => 'Documentations',
            'dnone' => 'display: none !important;',
            'columnSize' => 'col-lg-5'
        ];

        return view('pages/documentations', $data);
    }
}
