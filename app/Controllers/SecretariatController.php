<?php

namespace App\Controllers;
use CodeIgniter\Router\RouteCollection;

class SecretariatController extends BaseController
{
     public function dashboard()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 3) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];
        return view('/SecretariatDashboard', $data);
    }
}