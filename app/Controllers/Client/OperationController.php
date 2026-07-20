<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

use App\Models\ClientModel;
use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\TarifModel;
use App\Models\ActeModel;

class OperationController extends BaseController
{
    protected $clientModel;
    protected $compteModel;
    protected $operationModel;
    protected $tarifModel;
    protected $acteModel;

    /**
     
     *
     * @var \CodeIgniter\HTTP\RedirectResponse|null
     */
    protected $redirect = null;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->compteModel = new CompteModel();
        $this->operationModel = new OperationModel();
        $this->tarifModel = new TarifModel();
        $this->acteModel = new ActeModel();
    }

 
    private function verifierCompte(int $idCompte): ?array
    {
        if (!session()->get('isLoggedIn')) {
            $this->redirect = redirect()->to('/login');
            return null;
        }

        $compte = $this->compteModel->find($idCompte);
        if (!$compte || $compte['id_client'] != session()->get('client_id')) {
            $this->redirect = redirect()->to('/dashboard')
                ->with('error', 'Compte introuvable ou non autorisé.');
            return null;
        }

        return $compte;
    }

    public function solde($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        $data = [
            'compte' => $compte,
            'solde'  => number_format($compte['solde'], 2, ',', ' '),
        ];

        return view('client/solde', $data);
    }

    public function depotForm($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        return view('client/depot', ['compte' => $compte]);
    }

    public function depot($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        $montant = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        $typeDepot = $this->operationModel->where('libelle', 'Dépôt')->first();
        if (!$typeDepot) {
            return redirect()->back()->with('error', 'Type d\'opération « Dépôt » introuvable.');
        }

        $db = $this->compteModel->db;
        $db->transStart();

        $this->compteModel->update($idCompte, [
            'solde' => $compte['solde'] + $montant,
        ]);

        $this->acteModel->insert([
            'id_compte_source'      => $idCompte,
            'id_compte_destination' => null,
            'id_type_operation'     => $typeDepot['id_type_operation'],
            'montant'               => $montant,
            'frais_applique'        => 0,
            'statut'                => 'Réussi',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Échec du dépôt. Veuillez réessayer.');
        }

        return redirect()->to('/compte/' . $idCompte . '/solde')
            ->with('success', 'Dépôt de ' . number_format($montant, 2, ',', ' ') . ' Ariary effectué avec succès.');
    }

    public function retraitForm($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        return view('client/retrait', ['compte' => $compte]);
    }

    public function retrait($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        $montant = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        $typeRetrait = $this->operationModel->where('libelle', 'Retrait')->first();
        if (!$typeRetrait) {
            return redirect()->back()->with('error', 'Type d\'opération « Retrait » introuvable.');
        }

        $frais = $this->tarifModel->calculerFrais($typeRetrait['id_type_operation'], $montant);
        $totalDebite = $montant + $frais;

        if ($totalDebite > $compte['solde']) {
            return redirect()->back()->with('error', 'Solde insuffisant pour ce retrait (montant + frais de ' . number_format($frais, 2, ',', ' ') . ' Ariary).');
        }

        $db = $this->compteModel->db;
        $db->transStart();

        $this->compteModel->update($idCompte, [
            'solde' => $compte['solde'] - $totalDebite,
        ]);

        $this->acteModel->insert([
            'id_compte_source'      => $idCompte,
            'id_compte_destination' => null,
            'id_type_operation'     => $typeRetrait['id_type_operation'],
            'montant'               => $montant,
            'frais_applique'        => $frais,
            'statut'                => 'Réussi',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Échec du retrait. Veuillez réessayer.');
        }

        $msg = 'Retrait de ' . number_format($montant, 2, ',', ' ') . ' Ariary effectué avec succès.';
        if ($frais > 0) {
            $msg .= ' Frais appliqués : ' . number_format($frais, 2, ',', ' ') . ' Ariary.';
        }

        return redirect()->to('/compte/' . $idCompte . '/solde')->with('success', $msg);
    }

    public function transfertForm($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        return view('client/transfert', ['compte' => $compte]);
    }

    public function transfert($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        $telephones = $this->request->getPost('telephone_destination');
        $montants   = $this->request->getPost('montant');

        if (empty($telephones) || empty($montants)) {
            return redirect()->back()->with('error', 'Veuillez ajouter au moins un destinataire avec un montant.');
        }

        if (count($telephones) !== count($montants)) {
            return redirect()->back()->with('error', 'Données invalides. Veuillez réessayer.');
        }

        $typeTransfert = $this->operationModel->where('libelle', 'Transfert')->first();
        if (!$typeTransfert) {
            return redirect()->back()->with('error', 'Type d\'opération « Transfert » introuvable.');
        }

        $db = $this->compteModel->db;
        $db->transStart();

        $totalDebite = 0;
        $transferts = [];

        foreach ($telephones as $index => $telephone) {
            $telephone = trim($telephone);
            $montant   = (float) $montants[$index];

            if (empty($telephone) || $montant <= 0) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Tous les champs doivent être remplis et les montants supérieurs à 0.');
            }

            $clientDestination = $this->clientModel->where('numero_telephone', $telephone)->first();
            if (!$clientDestination) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Aucun client trouvé avec le numéro ' . esc($telephone) . '.');
            }

            $compteDestination = $this->compteModel->where('id_client', $clientDestination['id_client'])->first();
            if (!$compteDestination) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Le client destinataire ' . esc($telephone) . ' n\'a aucun compte actif.');
            }

            $idDestination = (int) $compteDestination['id_compte'];

            if ($idDestination === $idCompte) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Le compte destinataire doit être différent du compte source pour le numéro ' . esc($telephone) . '.');
            }

            $frais = $this->tarifModel->calculerFrais($typeTransfert['id_type_operation'], $montant);
            $totalDebite += $montant + $frais;

            $transferts[] = [
                'idDestination' => $idDestination,
                'montant'       => $montant,
                'frais'         => $frais,
                'compteDest'    => $compteDestination,
            ];
        }

        if ($totalDebite > $compte['solde']) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Solde insuffisant pour ce transfert (total débité : ' . number_format($totalDebite, 2, ',', ' ') . ' Ariary).');
        }

        $this->compteModel->update($idCompte, [
            'solde' => $compte['solde'] - $totalDebite,
        ]);

        foreach ($transferts as $transfert) {
            $this->compteModel->update($transfert['idDestination'], [
                'solde' => $transfert['compteDest']['solde'] + $transfert['montant'],
            ]);

            $this->acteModel->insert([
                'id_compte_source'      => $idCompte,
                'id_compte_destination' => $transfert['idDestination'],
                'id_type_operation'     => $typeTransfert['id_type_operation'],
                'montant'               => $transfert['montant'],
                'frais_applique'        => $transfert['frais'],
                'statut'                => 'Réussi',
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Échec du transfert. Veuillez réessayer.');
        }

        $msg = 'Transfert de ' . number_format($totalDebite, 2, ',', ' ') . ' Ariary vers ' . count($transferts) . ' compte(s) effectué avec succès.';
        return redirect()->to('/compte/' . $idCompte . '/solde')->with('success', $msg);
    }

   

    public function historique($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        $transactions = $this->acteModel
            ->select('Acte.*, Operation.libelle')
            ->join('Operation', 'Operation.id_type_operation = Acte.id_type_operation', 'left')
            ->groupStart()
            ->where('id_compte_source', $idCompte)
            ->orWhere('id_compte_destination', $idCompte)
            ->groupEnd()
            ->orderBy('date_operation', 'DESC')
            ->findAll();

        $data = [
            'compte'       => $compte,
            'transactions' => $transactions,
        ];

        return view('client/historique', $data);
    }
}
