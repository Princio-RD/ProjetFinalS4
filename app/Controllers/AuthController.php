<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CompteModel;
use App\Models\OperateurModel;


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
        $operateurModel = new OperateurModel();

        $numero = $this->request->getPost('numero_telephone');

        if (empty($numero)) {
            return redirect()->back()->with('error', 'Veuillez entrer un numéro de téléphone.');
        }

        $client = $clientModel->where('numero_telephone', $numero)->first();

        if (!$client) {
            return redirect()->back()->with('error', 'Numéro de téléphone non trouvé : ' . $numero);
        }

        
        $clientId = $client['id_client'] ?? 'NON TROUVÉ';
        $debugMsg = 'Client: ' . print_r($client, true) . ' | id_client=' . $clientId;

        $comptes = $compteModel->where('id_client', $clientId)->findAll();
        if (empty($comptes)) {
            return redirect()->back()->with('error', 'Aucun compte associé à ce client. ' . $debugMsg);
        }

        
        foreach ($comptes as &$compte) {
            $operateur = $operateurModel->find($compte['id_operateur']);
            $compte['nom'] = $operateur['nom'] ?? 'Inconnu';
        }
        unset($compte);

        $session->set([
            'client_id' => $clientId,
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
