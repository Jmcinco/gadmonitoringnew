<?php

namespace App\Controllers;

use App\Models\LoginModel;

class HashPasswordsController extends BaseController
{
    public function updateAllPasswords()
    {
        $model = new LoginModel();
        $employees = $model->findAll();

        foreach ($employees as $employee) {
            if ($employee['password'] && !preg_match('/^\$2y\$/', $employee['password'])) {
                $newPassword = password_hash($employee['password'], PASSWORD_BCRYPT);
                $model->update($employee['emp_id'], ['password' => $newPassword]);
                log_message('debug', "Updated password for {$employee['email']} to bcrypt hash");
            }
        }

        return redirect()->to('/login')->with('success', 'Passwords updated to bcrypt hashes');
    }
}