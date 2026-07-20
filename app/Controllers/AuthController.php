<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CompteModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('client/login');
    }

    public function loginAuto()
    {
        $session = session();
        $clientModel = new ClientModel();
        $compteModel = new CompteModel();

        $numero = $this->request->getPost('numero_telephone');

        if (empty($numero)) {
            return redirect()->back()->with('error', 'Veuillez entrer un numéro de téléphone.');
        }

        $client = $clientModel->where('numero_telephone', $numero)->first();

        if (!$client) {
            return redirect()->back()->with('error', 'Numéro de téléphone non trouvé.');
        }

        $comptes = $compteModel->where('id_client', $client['id_client'])->findAll();

        if (empty($comptes)) {
            return redirect()->back()->with('error', 'Aucun compte associé à ce client.');
        }

        $session->set([
            'client_id' => $client['id_client'],
            'numero_telephone' => $client['numero_telephone'],
            'comptes' => $comptes,
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
