<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        return view('admin/login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        if ($username === 'local' && $password === 'okeybrada') {
            session()->set('admin_logged_in', true);
            return redirect()->to('/admin');
        }
        
        return redirect()->back()->with('error', 'Identifiants incorrects');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}