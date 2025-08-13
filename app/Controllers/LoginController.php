<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\AuditTrailModel;

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
                'div_id' => $user['div_id'],
                'isLoggedIn' => true
            ]);
            log_message('debug', "Session set for {$email}, role_id: {$user['role_id']}");

            // Log successful login
            $auditModel = new AuditTrailModel();
            $auditModel->logActivity([
                'user_id' => $user['emp_id'],
                'action' => 'LOGIN',
                'table_name' => 'employees',
                'record_id' => $user['emp_id'],
                'employee_name' => $user['first_name'] . ' ' . $user['last_name'],
                'employee_email' => $user['email'],
                'details' => 'User logged in successfully'
            ]);
            switch ($user['role_id']) {
                case 1: // Focal
                    log_message('debug', "Redirecting {$email} to /FocalDashboard");
                    return redirect()->to('/FocalDashboard'); // Update when route is defined
                case 2: // Member
                    log_message('debug', "Redirecting {$email} to /MemberDashboard");
                    return redirect()->to('/MemberDashboard'); // Update when route is defined
                case 3: // Secretariat
                    log_message('debug', "Redirecting {$email} to /SecretariatDashboard");
                    return redirect()->to('/SecretariatDashboard'); // Update when route is defined
                case 4: // Administrator
                    log_message('debug', "Redirecting {$email} to /AdminDashboard");
                    return redirect()->to('/AdminDashboard'); // Update when route is defined
                default:
                    log_message('error', "Unknown role_id: {$user['role_id']} for {$email}");
                    return redirect()->to('/login')->with('error', 'Unknown role assigned.');
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
            log_message('error', "Failed to create user with email: {$data['email']}");
            return redirect()->back()->with('error', 'Failed to create user. Check your input or duplicate email.');
        }
        log_message('debug', "User created successfully: {$data['email']}");
        return redirect()->to('/login')->with('success', 'User created');
    }

    public function logout()
    {
        // Log logout before destroying session
        if (session()->get('isLoggedIn')) {
            $auditModel = new AuditTrailModel();
            $auditModel->logActivity([
                'user_id' => session()->get('user_id'),
                'action' => 'LOGOUT',
                'table_name' => 'employees',
                'record_id' => session()->get('user_id'),
                'employee_name' => session()->get('first_name') . ' ' . session()->get('last_name'),
                'employee_email' => session()->get('email'),
                'details' => 'User logged out'
            ]);
        }

        session()->destroy();
        log_message('debug', 'User logged out');
        return redirect()->to('/login');
    }
}