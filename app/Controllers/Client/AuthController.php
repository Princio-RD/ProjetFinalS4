<?php

namespace App\Controllers\Client;

use App\Models\ClientModel;
use App\Models\CompteModel;
use App\Models\OperateurModel;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('client/login');
    }

    public function loginAuto()
    {
        $session = session();
        $clientModel = new ClientModel();
        $compteModel = new CompteModel();
        $operateurModel = new OperateurModel();

        $numero = $this->request->getPost('numero_telephone');

        if (empty($numero)) {
            return redirect()->back()->with('error', 'Veuillez entrer un numéro de téléphone.');
        }

        $compte = $compteModel->where('numero_telephone', $numero)->first();

        if (!$compte) {
            return redirect()->back()->with('error', 'Numéro de téléphone non trouvé : ' . $numero);
        }
        
        $clientId = $compte['id_client'];
        
        $client = $clientModel->find($clientId);
        $clientNom = $client['nom'] ?? 'Client';
        
        $operateur = $operateurModel->find($compte['id_operateur']);
        $compte['nom'] = $operateur['nom'] ?? 'Inconnu';

        $session->set([
            'client_id' => $clientId,
            'client_nom' => $clientNom,
            'numero_telephone' => $compte['numero_telephone'],
            'compte' => $compte,
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