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

        $compteModel = new CompteModel();
        $comptes = $compteModel->getComptesWithOperateurByClient(session()->get('client_id'));

        $data = [
            'client' => [
                'id_client' => session()->get('client_id'),
                'numero_telephone' => session()->get('numero_telephone'),
            ],
            'comptes' => $comptes,
        ];

        return view('client/dashboard', $data);
    }
}
