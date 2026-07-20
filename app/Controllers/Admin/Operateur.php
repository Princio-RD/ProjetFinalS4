<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OperateurModel;

class Operateur extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new OperateurModel();
        return view('admin/operateur', ['operateurs' => $model->findAll()]);
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

    public function delete($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $model = new OperateurModel();
        $model->delete($id);
        return redirect()->to('/admin/operateur')->with('success', 'Préfixe supprimé');
    }
}