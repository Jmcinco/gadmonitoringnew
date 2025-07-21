<?php

namespace App\Models;

use CodeIgniter\Model;

class GadMandateModel extends Model
{
    protected $table = 'plan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'year' => 'required|is_natural_no_zero',
        'description' => 'required|min_length[10]'
    ];
    protected $validationMessages = [
        'year' => [
            'required' => 'The year is required.',
            'is_natural_no_zero' => 'The year must be a valid positive number.'
        ],
        'description' => [
            'required' => 'The description is required.',
            'min_length' => 'The description must be at least 10 characters long.'
        ]
    ];

    public function getMandates($year = null)
    {
        if ($year) {
            return $this->where('year', $year)->findAll();
        }
        return $this->findAll();
    }

    public function getMandateById($id)
    {
        return $this->find($id);
    }
}
