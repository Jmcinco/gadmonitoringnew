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

    protected $allowedFields = [
        'first_name',
        'last_name',
        'div_id',
        'pos_id',
        'role_id',
        'gender',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false; // Set true if you want CI to handle created_at/updated_at automatically

    // If you want validation rules, add here
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}