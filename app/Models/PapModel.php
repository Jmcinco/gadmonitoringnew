<?php

namespace App\Models;
use CodeIgniter\Model;

class PapModel extends Model
{
    protected $table = 'pap';
    protected $primaryKey = 'pap_id';
    protected $allowedFields = ['pap', 'mfo_id'];

    public function getAllWithMfo() {
        return $this->select('pap.*, mfo.mfo_code, mfo.mfo')
                    ->join('mfo', 'mfo.mfo_id = pap.mfo_id', 'left')
                    ->findAll();
    }
}