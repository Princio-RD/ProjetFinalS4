<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OperationModel;
use App\Models\TarifModel;

class Operation extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $operationModel = new OperationModel();
        $tarifModel = new TarifModel();

        $data = [
            'operations' => $operationModel->findAll(),
            'tarifs' => $tarifModel
                        ->select('Tarif.*, Operation.libelle')
                        ->join('Operation', 'Operation.id_type_operation = Tarif.id_type_operation')
                        ->orderBy('id_type_operation')
                        ->orderBy('montant_min')
                        ->findAll()
        ];

        return view('admin/operation', $data);
    }

    public function storeOperation()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new OperationModel();
        $model->save(['libelle' => $this->request->getPost('libelle')]);
        return redirect()->to('/admin/operation')->with('success', 'Type ajouté');
    }

    public function storeTarif()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new TarifModel();
        $model->save([
            'id_type_operation' => $this->request->getPost('id_type_operation'),
            'montant_min' => $this->request->getPost('montant_min'),
            'montant_max' => $this->request->getPost('montant_max'),
            'frais' => $this->request->getPost('frais')
        ]);

        return redirect()->to('/admin/operation')->with('success', 'Barème ajouté');
    }

    public function deleteTarif($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new TarifModel();
        $model->delete($id);
        return redirect()->to('/admin/operation')->with('success', 'Barème supprimé');
    }
}