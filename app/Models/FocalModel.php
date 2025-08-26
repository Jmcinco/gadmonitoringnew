<?php

namespace App\Models;

use CodeIgniter\Model;

class FocalModel extends Model
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
        'approved_at',
        'reviewed_by',
        'reviewed_at',
        'returned_by',
        'returned_at',
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

    public function getGadPlans($divisionId = null)
    {
        $builder = $this->select('plan_id, activity, gad_objective, status, authors_division, startDate, endDate')
                        ->whereNotIn('status', ['deleted'])
                        ->orderBy('plan_id', 'DESC');

        // More lenient activity filtering - allow NULL but not empty string
        $builder->where('(activity IS NOT NULL AND activity != "") OR activity IS NULL');

        // Apply division filter if provided
        if ($divisionId !== null) {
            $builder->where('authors_division', $divisionId);
        }

        $result = $builder->findAll();

        // Post-process to handle NULL activities
        foreach ($result as &$plan) {
            if (empty($plan['activity'])) {
                $plan['activity'] = 'Untitled GAD Activity';
            }
        }



        return $result;
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
     public function getGadPlansWithAmount($divisionId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('plan')
                     ->select('plan.*, COALESCE(SUM(budget.amount), 0) AS amount, divisions.division AS submitted_by_division')
                     ->join('budget', 'budget.plan_id = plan.plan_id', 'left')
                     ->join('divisions', 'divisions.div_id = plan.authors_division', 'left')
                     ->groupBy('plan.plan_id, divisions.division')
                     ->orderBy('plan.plan_id', 'DESC');

        // Apply division filter if provided
        if ($divisionId !== null) {
            $builder->where('plan.authors_division', $divisionId);
        }

        return $builder->get()->getResultArray();
    }
}