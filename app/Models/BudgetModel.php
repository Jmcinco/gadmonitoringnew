<?php

namespace App\Models;

use CodeIgniter\Model;

class BudgetModel extends Model
{
    protected $table = 'Budget';
    protected $primaryKey = 'act_id';
    protected $allowedFields = ['plan_id', 'obj_id', 'src_id', 'particulars', 'amount'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'plan_id' => 'required|is_natural_no_zero',
        'obj_id' => 'required|is_natural_no_zero',
        'src_id' => 'required|is_natural_no_zero',
        'particulars' => 'required|min_length[5]',
        'amount' => 'required|numeric|greater_than[0]'
    ];
}