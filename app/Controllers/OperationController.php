<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\TarifModel;
use App\Models\TransactionModel;

class OperationController extends BaseController
{
    protected $compteModel;
    protected $operationModel;
    protected $tarifModel;
    protected $transactionModel;

    /**
     
     *
     * @var \CodeIgniter\HTTP\RedirectResponse|null
     */
    protected $redirect = null;

    public function __construct()
    {
        $this->compteModel = new CompteModel();
        $this->operationModel = new OperationModel();
        $this->tarifModel = new TarifModel();
        $this->transactionModel = new TransactionModel();
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

        $this->transactionModel->insert([
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
            ->with('success', 'Dépôt de ' . number_format($montant, 2, ',', ' ') . ' FCFA effectué avec succès.');
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
            return redirect()->back()->with('error', 'Solde insuffisant pour ce retrait (montant + frais de ' . number_format($frais, 2, ',', ' ') . ' FCFA).');
        }

        $db = $this->compteModel->db;
        $db->transStart();

        $this->compteModel->update($idCompte, [
            'solde' => $compte['solde'] - $totalDebite,
        ]);

        $this->transactionModel->insert([
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

        $msg = 'Retrait de ' . number_format($montant, 2, ',', ' ') . ' FCFA effectué avec succès.';
        if ($frais > 0) {
            $msg .= ' Frais appliqués : ' . number_format($frais, 2, ',', ' ') . ' FCFA.';
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

        $idDestination = (int) $this->request->getPost('id_compte_destination');
        $montant       = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        if ($idDestination === $idCompte) {
            return redirect()->back()->with('error', 'Le compte destinataire doit être différent du compte source.');
        }

        $compteDestination = $this->compteModel->find($idDestination);
        if (!$compteDestination) {
            return redirect()->back()->with('error', 'Le compte destinataire est introuvable.');
        }

        $typeTransfert = $this->operationModel->where('libelle', 'Transfert')->first();
        if (!$typeTransfert) {
            return redirect()->back()->with('error', 'Type d\'opération « Transfert » introuvable.');
        }

        $frais = $this->tarifModel->calculerFrais($typeTransfert['id_type_operation'], $montant);
        $totalDebite = $montant + $frais;

        if ($totalDebite > $compte['solde']) {
            return redirect()->back()->with('error', 'Solde insuffisant pour ce transfert (montant + frais de ' . number_format($frais, 2, ',', ' ') . ' FCFA).');
        }

        $db = $this->compteModel->db;
        $db->transStart();

        $this->compteModel->update($idCompte, [
            'solde' => $compte['solde'] - $totalDebite,
        ]);

        $this->compteModel->update($idDestination, [
            'solde' => $compteDestination['solde'] + $montant,
        ]);

        $this->transactionModel->insert([
            'id_compte_source'      => $idCompte,
            'id_compte_destination' => $idDestination,
            'id_type_operation'     => $typeTransfert['id_type_operation'],
            'montant'               => $montant,
            'frais_applique'        => $frais,
            'statut'                => 'Réussi',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Échec du transfert. Veuillez réessayer.');
        }

        $msg = 'Transfert de ' . number_format($montant, 2, ',', ' ') . ' FCFA vers le compte n° ' . $idDestination . ' effectué avec succès.';
        if ($frais > 0) {
            $msg .= ' Frais appliqués : ' . number_format($frais, 2, ',', ' ') . ' FCFA.';
        }

        return redirect()->to('/compte/' . $idCompte . '/solde')->with('success', $msg);
    }

    public function historique($idCompte)
    {
        $compte = $this->verifierCompte($idCompte);
        if ($compte === null) {
            return $this->redirect;
        }

        $transactions = $this->transactionModel
            ->select('Transaction.*, Operation.libelle')
            ->join('Operation', 'Operation.id_type_operation = Transaction.id_type_operation', 'left')
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
