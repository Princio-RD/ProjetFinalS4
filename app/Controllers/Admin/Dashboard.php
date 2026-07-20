<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\CompteModel;
use App\Models\ActeModel;
use App\Models\OperateurModel;
use App\Models\OperationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $clientModel = new ClientModel();
        $compteModel = new CompteModel();
        $acteModel = new ActeModel();
        $operationModel = new OperationModel();

        $clients = $clientModel->findAll();
        $comptes = $compteModel->findAll();
        
        $solde_total = 0;
        foreach ($comptes as $c) {
            $solde_total += $c['solde'];
        }

        $operations = $operationModel->findAll();
        $gains_par_operation = [];
        $total_gains = 0;
        
        foreach ($operations as $op) {
            $total = $acteModel->selectSum('frais_applique')
                               ->where('id_type_operation', $op['id_type_operation'])
                               ->where('statut', 'Réussi')
                               ->first()['frais_applique'] ?? 0;
            
            $gains_par_operation[$op['libelle']] = $total;
            $total_gains += $total;
        }

        $clients_avec_comptes = [];
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
            
            $clients_avec_comptes[] = [
                'client' => $client,
                'comptes' => $comptes_client,
                'solde_total' => $solde_total_client,
                'nombre_comptes' => count($comptes_client)
            ];
        }

        $comptes_par_operateur = $compteModel
            ->select('Operateur.nom, Operateur.prefixe, COUNT(Compte.id_compte) as total, SUM(Compte.solde) as solde_total')
            ->join('Operateur', 'Operateur.id_operateur = Compte.id_operateur')
            ->groupBy('Compte.id_operateur')
            ->findAll();

        $data = [
            'title' => 'Dashboard Admin',
            'total_clients' => count($clients),
            'total_comptes' => count($comptes),
            'solde_total' => $solde_total,
            'gains_par_operation' => $gains_par_operation,
            'total_gains' => $total_gains,
            'clients_avec_comptes' => $clients_avec_comptes,
            'comptes_par_operateur' => $comptes_par_operateur,
        ];

        return view('admin/dashboard', $data);
    }
}