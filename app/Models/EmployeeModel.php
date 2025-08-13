<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employees';
    protected $primaryKey = 'emp_id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'div_id',
        'pos_id',
        'role_id',
        'gender',
        'email',
        'password'
    ];

    // Remove validation rules from model since we handle validation in controller
    protected $validationRules = [];
    protected $validationMessages = [];
}