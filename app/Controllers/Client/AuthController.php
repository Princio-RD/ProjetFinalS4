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
        $clientId = $compte['id_client'] ?? 'NON TROUVÉ';
        $comptes = $compteModel->where('id_client', $clientId)->findAll();
        if (empty($comptes)) {
            return redirect()->back()->with('error', 'Aucun compte associé à ce client.');
        }

        
        foreach ($comptes as &$compteItem) {
            $operateur = $operateurModel->find($compteItem['id_operateur']);
            $compteItem['nom'] = $operateur['nom'] ?? 'Inconnu';
        }
        unset($compteItem);

        $session->set([
            'client_id' => $clientId,
            'numero_telephone' => $compte['numero_telephone'],
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
