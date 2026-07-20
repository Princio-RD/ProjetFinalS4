<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\CompteModel;
use App\Models\ActeModel;
use App\Models\OperateurModel;
use App\Models\OperationModel;
use App\Models\CommissionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'total_clients' => $this->getTotalClients(),
            'total_comptes' => $this->getTotalComptes(),
            'solde_total' => $this->getSoldeTotal(),
            'gains_par_operateur' => $this->getGainsParOperateur(),
            'gains_details' => $this->getGainsDetails(),
            'total_gains' => $this->getTotalGains(),
            'montants_a_envoyer' => $this->getMontantsAEnvoyer(),
            'clients_avec_comptes' => $this->getClientsAvecComptes(),
            'comptes_par_operateur' => $this->getComptesParOperateur(),
        ];

        return view('admin/dashboard', $data);
    }

    // =========================================================
    // 1. Situation des comptes clients
    // =========================================================

    private function getTotalClients()
    {
        return (new ClientModel())->countAll();
    }

    private function getTotalComptes()
    {
        return (new CompteModel())->countAll();
    }

    private function getSoldeTotal()
    {
        $result = (new CompteModel())->selectSum('solde')->first();
        return $result['solde'] ?? 0;
    }

    // =========================================================
    // 2. Gains par operateur
    // =========================================================

    private function getGainsParOperateur()
    {
        $acteModel = new ActeModel();
        $operateurs = (new OperateurModel())->findAll();
        $gains = [];
        
        foreach ($operateurs as $op) {
            $total = $acteModel
                ->selectSum('frais_applique')
                ->join('Compte', 'Compte.id_compte = Acte.id_compte_source')
                ->where('Compte.id_operateur', $op['id_operateur'])
                ->where('Acte.statut', 'Réussi')
                ->first()['frais_applique'] ?? 0;
            
            $gains[$op['id_operateur']] = [
                'nom' => $op['nom'],
                'prefixe' => $op['prefixe'],
                'total' => $total
            ];
        }
        
        return $gains;
    }

    private function getGainsDetails()
    {
        $acteModel = new ActeModel();
        $operateurs = (new OperateurModel())->findAll();
        $operations = (new OperationModel())->findAll();
        $details = [];

        foreach ($operateurs as $op) {
            $details[$op['id_operateur']] = [
                'nom' => $op['nom'],
                'prefixe' => $op['prefixe'],
                'depot' => 0,
                'retrait' => 0,
                'transfert' => 0
            ];

            foreach ($operations as $operation) {
                $type = strtolower($operation['libelle']);
                $montant = $acteModel
                    ->selectSum('frais_applique')
                    ->join('Compte', 'Compte.id_compte = Acte.id_compte_source')
                    ->where('Compte.id_operateur', $op['id_operateur'])
                    ->where('Acte.id_type_operation', $operation['id_type_operation'])
                    ->where('Acte.statut', 'Réussi')
                    ->first()['frais_applique'] ?? 0;

                $details[$op['id_operateur']][$type] = $montant;
            }
        }

        return $details;
    }

    private function getTotalGains()
    {
        $result = (new ActeModel())
            ->selectSum('frais_applique')
            ->where('statut', 'Réussi')
            ->first();
        return $result['frais_applique'] ?? 0;
    }

    // =========================================================
    // 3. Montants à envoyer
    // =========================================================

    private function getMontantsAEnvoyer()
    {
        $acteModel = new ActeModel();
        $commissionModel = new CommissionModel();
        $operateurs = (new OperateurModel())->findAll();
        $montants = [];
        
        foreach ($operateurs as $op_dest) {
            $total_a_payer = 0;
            $details = [];

            foreach ($operateurs as $op_source) {
                if ($op_source['id_operateur'] == $op_dest['id_operateur']) {
                    continue;
                }
                
                $commission = $commissionModel
                    ->where('id_operateur_source', $op_source['id_operateur'])
                    ->where('id_operateur_destination', $op_dest['id_operateur'])
                    ->first();
                
                $pourcentage = $commission ? (float) $commission['pourcentage'] : 0;
                
                if ($pourcentage > 0) {
                    $frais_transferts = $acteModel
                        ->selectSum('frais_applique')
                        ->join('Compte as CompteSource', 'CompteSource.id_compte = Acte.id_compte_source')
                        ->join('Compte as CompteDest', 'CompteDest.id_compte = Acte.id_compte_destination', 'left')
                        ->where('CompteSource.id_operateur', $op_source['id_operateur'])
                        ->where('CompteDest.id_operateur', $op_dest['id_operateur'])
                        ->where('Acte.id_type_operation', 3)
                        ->where('Acte.statut', 'Réussi')
                        ->first()['frais_applique'] ?? 0;
                    
                    $montant_commission = $frais_transferts * ($pourcentage / 100);
                    $total_a_payer += $montant_commission;

                    $details[] = [
                        'source' => $op_source['nom'] . ' (' . $op_source['prefixe'] . ')',
                        'frais' => $frais_transferts,
                        'pourcentage' => $pourcentage,
                        'montant' => $montant_commission
                    ];
                }
            }
            
            $montants[$op_dest['id_operateur']] = [
                'nom' => $op_dest['nom'],
                'prefixe' => $op_dest['prefixe'],
                'total_a_payer' => $total_a_payer,
                'details' => $details
            ];
        }
        
        return $montants;
    }

    // =========================================================
    // 4. Clients avec leurs comptes
    // =========================================================

    private function getClientsAvecComptes()
    {
        $clientModel = new ClientModel();
        $compteModel = new CompteModel();
        $clients = $clientModel->findAll();
        $result = [];

        foreach ($clients as $client) {
            $comptes_client = $compteModel
                ->select('Compte.*, Operateur.nom as operateur_nom, Operateur.prefixe')
                ->join('Operateur', 'Operateur.id_operateur = Compte.id_operateur')
                ->where('id_client', $client['id_client'])
                ->findAll();

            $solde_total_client = 0;
            foreach ($comptes_client as $c) {
                $solde_total_client += $c['solde'];
            }

            $numero_telephone = '';
            if (!empty($comptes_client)) {
                $numero_telephone = $comptes_client[0]['numero_telephone'] ?? '';
            }

            $result[] = [
                'client' => $client,
                'comptes' => $comptes_client,
                'solde_total' => $solde_total_client,
                'nombre_comptes' => count($comptes_client),
                'numero_telephone' => $numero_telephone,
            ];
        }

        return $result;
    }

    // =========================================================
    // 5. Comptes par operateur
    // =========================================================

    private function getComptesParOperateur()
    {
        $compteModel = new CompteModel();
        return $compteModel
            ->select('Operateur.nom, Operateur.prefixe, COUNT(Compte.id_compte) as total, SUM(Compte.solde) as solde_total')
            ->join('Operateur', 'Operateur.id_operateur = Compte.id_operateur')
            ->groupBy('Compte.id_operateur')
            ->findAll();
    }
}