<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'plan';
    protected $primaryKey = 'plan_id';
    protected $allowedFields = [
        'issue_mandate',
        'cause',
        'gad_objective',
        'activity',
        'indicator_text',
        'target_text',
        'startDate',
        'endDate',
        'responsible_units',
        'budget',
        'mfoPapData',
        'status',
        'remarks',
        'approved_by',
        'mfo_id',
        'pap_id',
        'file_attachments',
        'hgdg_score',
        'authors_division'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'issue_mandate' => 'required|min_length[10]',
        'cause' => 'required|min_length[10]',
        'gad_objective' => 'required|min_length[10]',
        'activity' => 'required|min_length[10]',
        'indicators' => 'required|min_length[10]',
        'startDate' => 'required|valid_date',
        'endDate' => 'required|valid_date',
        'responsible_units' => 'required', 
        'budget' => 'required|numeric|greater_than[0]',
        'mfoPapData' => 'permit_empty|valid_json'
    ];

    protected $validationMessages = [
        'issue_mandate' => [
            'required' => 'Gender issue or GAD mandate is required.',
            'min_length' => 'Gender issue or GAD mandate must be at least 10 characters long.'
        ],
        'cause' => [
            'required' => 'Cause of issue is required.',
            'min_length' => 'Cause of issue must be at least 10 characters long.'
        ],
        'gad_objective' => [
            'required' => 'GAD objective is required.',
            'min_length' => 'GAD objective must be at least 10 characters long.'
        ],
        'activity' => [
            'required' => 'GAD activity is required.',
            'min_length' => 'GAD activity must be at least 10 characters long.'
        ],
        'indicators' => [
            'required' => 'Performance targets are required.',
            'min_length' => 'Performance targets must be at least 10 characters long.'
        ],
        'startDate' => [
            'required' => 'Start date is required.',
            'valid_date' => 'Please enter a valid start date.'
        ],
        'endDate' => [
            'required' => 'End date is required.',
            'valid_date' => 'Please enter a valid end date.'
        ],
        'responsible_units' => [
            'required' => 'Responsible unit is required.'
        ],
        'budget' => [
            'required' => 'Budget amount is required.',
            'numeric' => 'Budget amount must be a number.',
            'greater_than' => 'Budget amount must be greater than 0.'
        ],
        'mfoPapData' => [
            'valid_json' => 'MFO/PAP data must be a valid JSON string.'
        ]
    ];

    public function getGadPlans()
    {
        return $this->findAll();
    }

    public function getGadPlanById($id)
    {
        return $this->find($id);
    }

    protected function beforeInsert(array $data)
    {
        if (isset($data['data']['startDate']) && isset($data['data']['endDate'])) {
            $startDate = strtotime($data['data']['startDate']);
            $endDate = strtotime($data['data']['endDate']);
            if ($endDate <= $startDate) {
                throw new \Exception('End date must be after start date.');
            }
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if (isset($data['data']['startDate']) && isset($data['data']['endDate'])) {
            $startDate = strtotime($data['data']['startDate']);
            $endDate = strtotime($data['data']['endDate']);
            if ($endDate <= $startDate) {
                throw new \Exception('End date must be after start date.');
            }
        }
        return $data;
    }
     public function getGadPlansWithAmount()
    {
        $db = \Config\Database::connect();
        $query = "
            SELECT
                plan.*,
                COALESCE(SUM(budget.amount), 0) AS amount,
                divisions.division AS submitted_by_division
            FROM plan
            LEFT JOIN budget ON budget.plan_id = plan.plan_id
            LEFT JOIN divisions ON divisions.div_id = plan.authors_division
            GROUP BY plan.plan_id, divisions.division
            ORDER BY plan.plan_id DESC
        ";
        return $db->query($query)->getResultArray();
    }
}