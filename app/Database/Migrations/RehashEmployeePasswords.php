<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RehashEmployeePasswords extends Migration
{
    public function up()
    {
        $model = new \App\Models\LoginModel();
        $employees = $model->findAll();
        foreach ($employees as $employee) {
            if (!password_verify($employee['password'], $employee['password'])) {
                $model->update($employee['emp_id'], ['password' => password_hash($employee['password'], PASSWORD_BCRYPT)]);
            }
        }
    }

    public function down()
    {
        // Optional revert
    }
}