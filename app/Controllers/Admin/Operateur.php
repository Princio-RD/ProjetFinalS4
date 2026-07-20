<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OperateurModel;
use App\Models\CommissionModel;

class Operateur extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $operateurModel = new OperateurModel();
        $commissionModel = new CommissionModel();

        $data = [
            'operateurs' => $operateurModel->findAll(),
            'commissions' => $commissionModel->getAllCommissions()
        ];

        return view('admin/operateur', $data);
    }

    public function store()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new OperateurModel();
        $model->save([
            'nom' => $this->request->getPost('nom'),
            'prefixe' => $this->request->getPost('prefixe')
        ]);

        return redirect()->to('/admin/operateur')->with('success', 'Préfixe ajouté');
    }

    // operateur
    public function delete($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new OperateurModel();
        $model->delete($id);
        return redirect()->to('/admin/operateur')->with('success', 'Préfixe supprimé');
    }

    public function edit($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new OperateurModel();
        $commissionModel = new CommissionModel();

        $operateur = $model->find($id);

        if (!$operateur) {
            return redirect()->to('/admin/operateur')->with('error', 'Opérateur non trouvé.');
        }

        $operateurs = $model->findAll();
        $commissions = $commissionModel->getAllCommissions();

        return view('admin/edit', [
            'operateur' => $operateur,
            'operateurs' => $operateurs,
            'commissions' => $commissions
        ]);
    }

    public function update($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new OperateurModel();
        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'prefixe' => $this->request->getPost('prefixe')
        ]);

        return redirect()->to('/admin/operateur')->with('success', 'Préfixe mis à jour');
    }

    // commission
    public function storeCommission()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $commissionModel = new CommissionModel();

        $existing = $commissionModel
            ->where('id_operateur_source', $this->request->getPost('id_operateur_source'))
            ->where('id_operateur_destination', $this->request->getPost('id_operateur_destination'))
            ->first();

        if ($existing) {
            $commissionModel->update($existing['id_commission'], [
                'pourcentage' => $this->request->getPost('pourcentage')
            ]);
        } else {
            $commissionModel->save([
                'id_operateur_source' => $this->request->getPost('id_operateur_source'),
                'id_operateur_destination' => $this->request->getPost('id_operateur_destination'),
                'pourcentage' => $this->request->getPost('pourcentage')
            ]);
        }

        return redirect()->to('/admin/operateur')->with('success', 'Commission configurée');
    }

    public function deleteCommission($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $commissionModel = new CommissionModel();
        $commissionModel->delete($id);

        return redirect()->to('/admin/operateur')->with('success', 'Commission supprimée');
    }
}