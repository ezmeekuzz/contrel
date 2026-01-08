<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel | Dashboard',
            'currentpage' => 'dashboard'
        ];

        return view('pages/admin/dashboard', $data);
    }
}
