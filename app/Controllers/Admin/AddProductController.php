<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;

class AddProductController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel | Add Product',
            'currentpage' => 'addproduct'
        ];

        return view('pages/admin/addproduct', $data);
    }

    public function insert()
    {
        
    }
}
