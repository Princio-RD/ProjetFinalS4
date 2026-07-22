<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteModel;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $compte = session()->get('compte');
        
        if (!$compte) {
            $compteModel = new CompteModel();
            $compte = $compteModel->where('numero_telephone', session()->get('numero_telephone'))->first();
            session()->set('compte', $compte);
        }

        $data = [
            'compte' => $compte,
        ];

        return view('client/dashboard', $data);
    }
}