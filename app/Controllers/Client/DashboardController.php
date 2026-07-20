<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'client' => [
                'id_client' => session()->get('client_id'),
                'numero_telephone' => session()->get('numero_telephone'),
            ],
            'comptes' => session()->get('comptes'),
        ];

        return view('client/dashboard', $data);
    }
}
