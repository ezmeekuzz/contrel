<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel Elettronica - Electronic Devices for Electrical Measurement and Protection',
            'banner' => '/images/products-banner.png',
            'h1Tag' => 'Our Products',
            'dnone' => 'display: none !important;',
            'columnSize' => 'col-lg-5'
        ];

        return view('pages/products', $data);
    }
}
