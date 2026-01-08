<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ContactUsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel Elettronica - Electronic Devices for Electrical Measurement and Protection',
            'banner' => '/images/contact-banner.png',
            'h1Tag' => 'Contact Us',
            'dnone' => 'display: none !important;',
            'columnSize' => 'col-lg-5'
        ];

        return view('pages/contact-us', $data);
    }
}
