<?php

namespace App\Models;
use CodeIgniter\Model;

class MfoModel extends Model
{
    protected $table = 'mfo';
    protected $primaryKey = 'mfo_id';
    protected $allowedFields = ['mfo_code', 'mfo'];
}