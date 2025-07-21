<?php

namespace App\Models;

use CodeIgniter\Model;

class MfoModel extends Model
{
    protected $table = 'MFO';
    protected $primaryKey = 'mfo_id';
    protected $allowedFields = ['mfo_code', 'mfo'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'mfo_code' => 'required|min_length[3]',
        'mfo' => 'required|min_length[5]'
    ];
}