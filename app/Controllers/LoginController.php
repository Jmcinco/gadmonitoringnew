<?php

namespace App\Controllers;

use App\Models\LoginModel;

class LoginController extends BaseController
{
    public function index()
    {
        helper('form');
        return view('login');
    }

public function authenticate()
{
    $model = new LoginModel();
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $user = $model->authenticate($email, $password);
    log_message('debug', "Authenticate called for {$email}, user: " . json_encode($user));

    if ($user) {
        $session = session();
        $session->set([
            'user_id' => $user['emp_id'],
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'isLoggedIn' => true
        ]);
        log_message('debug', "Session set for {$email}, role_id: {$user['role_id']}");
        switch ($user['role_id']) {;
            case 1: return redirect()->to('/Views/FocalDashboard');
            case 3: log_message('debug', "Redirecting to FocalDashboard for {$email}"); return redirect()->to('/Views/FocalDashboard');
            case 2: return redirect()->to('/Views/SecretariatDashboard');
            case 4: return redirect()->to('/Views/AdminDashboard');
            default: return redirect()->to('/Dashboard');
        }
    } else {
        log_message('debug', "Authentication failed for {$email}");
        return redirect()->back()->with('error', 'Invalid email or password');
    }
}
public function createUser()
{
    $model = new LoginModel();
    $data = [
        'first_name' => $this->request->getPost('first_name'),
        'last_name' => $this->request->getPost('last_name'),
        'role_id' => $this->request->getPost('role_id'),
        'div_id' => $this->request->getPost('div_id'),
        'gender' => $this->request->getPost('gender'),
        'email' => $this->request->getPost('email'),
        'password' => $this->request->getPost('password')
    ];

    if ($model->saveUser($data) === false) {
        return redirect()->back()->with('error', 'Failed to create user. Check your input or duplicate email.');
    }
    return redirect()->to('/login')->with('success', 'User created');
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}