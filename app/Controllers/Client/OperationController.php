<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\TarifModel;
use App\Models\ActeModel;
use App\Models\CommissionModel;

class OperationController extends BaseController
{
    protected $clientModel;
    protected $compteModel;
    protected $operationModel;
    protected $tarifModel;
    protected $acteModel;
    protected $commissionModel;

    protected $redirect = null;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->compteModel = new CompteModel();
        $this->operationModel = new OperationModel();
        $this->tarifModel = new TarifModel();
        $this->acteModel = new ActeModel();
        $this->commissionModel = new CommissionModel();
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
            'solde'  => number_format($compte['solde'], 0, ',', ' '),
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
            'commission_appliquee'  => 0,
            'statut'                => 'Réussi',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Échec du dépôt. Veuillez réessayer.');
        }

        return redirect()->to('/compte/' . $idCompte . '/solde')
            ->with('success', 'Dépôt de ' . number_format($montant, 0, ',', ' ') . ' Ariary effectué avec succès.');
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
            return redirect()->back()->with('error', 'Solde insuffisant pour ce retrait (montant + frais de ' . number_format($frais, 0, ',', ' ') . ' Ariary).');
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
            'commission_appliquee'  => 0,
            'statut'                => 'Réussi',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Échec du retrait. Veuillez réessayer.');
        }

        $msg = 'Retrait de ' . number_format($montant, 0, ',', ' ') . ' Ariary effectué avec succès.';
        if ($frais > 0) {
            $msg .= ' Frais appliqués : ' . number_format($frais, 0, ',', ' ') . ' Ariary.';
        }

        return redirect()->to('/compte/' . $idCompte . '/solde')->with('success', $msg);
    }



    public function getSoldeCompteTransfert($idCompte)
    { 
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        } 

        $pourcentageEpargne = 0;
    
          $comptes = $this->clientModel->find($idCompte);
      
        $data = [
             'solde'  => $compte
        ];

        return view('client/epargne' ,$data);
        

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

        if (empty($telephones) || empty($montants) || count($telephones) !== count($montants)) {
            return redirect()->back()->with('error', 'Données invalides.');
        }

        $typeTransfert = $this->operationModel->where('libelle', 'Transfert')->first();
        $typeRetrait = $this->operationModel->where('libelle', 'Retrait')->first();
        
        if (!$typeTransfert || !$typeRetrait) {
            return redirect()->back()->with('error', 'Type d\'opération introuvable.');
        }

        $db = $this->compteModel->db;
        $db->transStart();

        $totalDebite = 0;
        $totalCommission = 0;
        $totalMontantTransfere = 0;
        $totalFraisTransfert = 0;
        $totalFraisRetrait = 0;
        $transferts = [];
        $soldesDestinations = [];
         $montantEpargne = 0;
         $montantRecus = 0;
         $ClientDestinateur = $this -> clientModel ->find($compteDestination);
         $pourcentageEpargne  = 0;

        foreach ($telephones as $index => $telephone) {
            $telephone = trim($telephone);
            $montant   = (float) $montants[$index];

            if (empty($telephone) || $montant <= 0) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Données invalides.');
            }

            $compteDestination = $this->compteModel->where('numero_telephone', $telephone)->first();
            if (!$compteDestination || $compteDestination['id_compte'] == $idCompte) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Destinataire invalide.');
            }

            $idDestination = (int) $compteDestination['id_compte'];
              
            // Calculs
            $fraisTransfert = $this->tarifModel->calculerFrais($typeTransfert['id_type_operation'], $montant);
            $fraisRetrait = $this->tarifModel->calculerFrais($typeRetrait['id_type_operation'], $montant);
            
            $commission = 0;
            if ($compte['id_operateur'] != $compteDestination['id_operateur']) {
                $pourcentage = $this->commissionModel->getCommission($compte['id_operateur'], $compteDestination['id_operateur']);
                $commission = $fraisTransfert * ($pourcentage / 100);
            }

            $totalDebite += $montant + $fraisTransfert + $fraisRetrait + $commission;
            $totalCommission += $commission;
            $totalMontantTransfere += $montant;
            $totalFraisTransfert += $fraisTransfert;
            $totalFraisRetrait += $fraisRetrait;

            $soldeActuelDest = $soldesDestinations[$idDestination] ?? $compteDestination['solde'];
            $transferts[] = [
                'idDestination' => $idDestination,
                'montant' => $montant,
                'fraisTransfert' => $fraisTransfert,
                'fraisRetrait' => $fraisRetrait,
                'commission' => $commission,
                'soldeDest' => $soldeActuelDest,
            ];
            $soldesDestinations[$idDestination] = $soldeActuelDest + $montant;
        }

        if ($totalDebite > $compte['solde']) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        // Mise à jour compte source
        $this->compteModel->update($idCompte, ['solde' => $compte['solde'] - $totalDebite]);

        // Insertion des actes
        foreach ($transferts as $t) {
            $this->compteModel->update($t['idDestination'], ['solde' => $t['soldeDest'] + $t['montant']]);
            $this->acteModel->insert([
                'id_compte_source' => $idCompte,
                'id_compte_destination' => $t['idDestination'],
                'id_type_operation' => $typeTransfert['id_type_operation'],
                'montant' => $t['montant'],
                'frais_applique' => $t['fraisTransfert'] + $t['fraisRetrait'],
                'commission_appliquee' => $t['commission'],
                'statut' => 'Réussi',
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Échec du transfert.');
        }

        $msg = 'Transfert de ' . number_format($totalMontantTransfere, 0, ',', ' ') . ' Ar effectué.';
        $msg .= ' Frais: ' . number_format($totalFraisTransfert + $totalFraisRetrait, 0, ',', ' ') . ' Ar';
        if ($totalCommission > 0) {
            $msg .= ', Commission: ' . number_format($totalCommission, 0, ',', ' ') . ' Ar';
        }
        
        
        
        return redirect()->to('/compte/' . $idCompte . '/solde')->with('success', $msg);
    }

    public function historique($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        $transactions = $this->acteModel
            ->select('Acte.*, Operation.libelle, Acte.id_acte as numero_transaction')
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