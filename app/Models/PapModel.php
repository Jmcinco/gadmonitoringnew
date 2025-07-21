<?php

namespace App\Models;

use CodeIgniter\Model;

class PapModel extends Model
{
    protected $table = 'PAP';
    protected $primaryKey = 'pap_id';
    protected $allowedFields = ['pap', 'mfo_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'pap' => 'required|min_length[5]',
        'mfo_id' => 'required|is_natural_no_zero'
    ];
}