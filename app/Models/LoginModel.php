<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'Employees';
    protected $primaryKey = 'emp_id';
    protected $allowedFields = ['first_name', 'last_name', 'role_id', 'div_id', 'gender', 'email', 'password'];


    public function authenticate($email, $password)
    {
        $user = $this->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    public function getUserRole($emp_id)
    {
        return $this->select('Employees.emp_id, Employees.role_id, Roles.role_name')
            ->join('Roles', 'Roles.role_id = Employees.role_id')
            ->where('Employees.emp_id', $emp_id)
            ->first();
    }

    public function saveUser($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        if (isset($data['emp_id'])) {
            // Update existing user
            return $this->update($data['emp_id'], $data);
        } else {
            // Insert new user
            return $this->insert($data, true);
        }
    }
}