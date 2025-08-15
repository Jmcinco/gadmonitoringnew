<?php

namespace App\Models;

use CodeIgniter\Model;

class OutputModel extends Model
{
    protected $table = 'output';
    protected $primaryKey = 'output_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    protected $allowedFields = [
        'plan_id',
        'accomplishment',
        'status',
        'date_accomplished',
        'file',
        'remarks',
        'accepted_by',
        'timestamp'
    ];

    protected $validationRules = [
        'plan_id' => 'required|is_natural_no_zero',
        'accomplishment' => 'required|min_length[3]',
        'status' => 'permit_empty|in_list[pending,completed,failed]'
    ];

    protected $validationMessages = [
        'plan_id' => [
            'required' => 'Plan ID is required',
            'is_natural_no_zero' => 'Plan ID must be a valid positive number'
        ],
        'accomplishment' => [
            'required' => 'Accomplishment is required',
            'min_length' => 'Accomplishment must be at least 3 characters long'
        ],
        'status' => [
            'in_list' => 'Status must be one of: pending, completed, failed'
        ]
    ];

    /**
     * Get accomplishments with related plan and division data
     */
    public function getAccomplishmentsWithDetails()
    {
        try {
            $db = \Config\Database::connect();

            // First, let's check what columns exist
            $query = $db->query("SHOW COLUMNS FROM output");
            $columns = $query->getResultArray();
            log_message('info', 'Output table columns: ' . json_encode($columns));

            // Use a simple query to get data
            $query = $db->query("
                SELECT
                    o.*,
                    p.activity as gad_activity,
                    p.authors_division,
                    d.division as office_name
                FROM output o
                LEFT JOIN plan p ON p.plan_id = o.plan_id
                LEFT JOIN divisions d ON d.div_id = p.authors_division
                ORDER BY o.date_accomplished DESC, o.timestamp DESC
            ");

            $result = $query->getResultArray();

            // Map the results to expected format
            $mapped = [];
            foreach ($result as $row) {
                $mapped[] = [
                    'output_id' => $row['output_id'],
                    'plan_id' => $row['plan_id'],
                    'accomplishment' => $row['accomplishment'],
                    'status' => $row['status'],
                    'date_accomplished' => $row['date_accomplished'],
                    'file' => $row['file'],
                    'remarks' => $row['remarks'],
                    'accepted_by' => $row['accepted_by'],
                    'timestamp' => $row['timestamp'],
                    'gad_activity' => $row['gad_activity'],
                    'authors_division' => $row['authors_division'],
                    'office_name' => $row['office_name']
                ];
            }

            return $mapped;
        } catch (\Exception $e) {
            log_message('error', 'Error getting accomplishments: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get accomplishment by ID with details
     */
    public function getAccomplishmentWithDetails($id)
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("
                SELECT
                    o.*,
                    p.activity as gad_activity,
                    p.authors_division,
                    d.division as office_name
                FROM output o
                LEFT JOIN plan p ON p.plan_id = o.plan_id
                LEFT JOIN divisions d ON d.div_id = p.authors_division
                WHERE o.output_id = ?
            ", [$id]);

            $result = $query->getRowArray();

            if ($result) {
                return [
                    'output_id' => $result['output_id'],
                    'plan_id' => $result['plan_id'],
                    'accomplishment' => $result['accomplishment'],
                    'status' => $result['status'],
                    'date_accomplished' => $result['date_accomplished'],
                    'file' => $result['file'],
                    'remarks' => $result['remarks'],
                    'accepted_by' => $result['accepted_by'],
                    'timestamp' => $result['timestamp'],
                    'gad_activity' => $result['gad_activity'],
                    'authors_division' => $result['authors_division'],
                    'office_name' => $result['office_name']
                ];
            }

            return null;
        } catch (\Exception $e) {
            log_message('error', 'Error getting accomplishment details: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all available GAD plans using plan_id
     */
    public function getAvailableGadPlans()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("
                SELECT
                    plan_id,
                    activity,
                    gad_objective,
                    budget,
                    status,
                    authors_division,
                    startDate,
                    endDate,
                    CONCAT('GAD', LPAD(plan_id, 3, '0')) as gad_activity_id,
                    d.division as office_name
                FROM plan p
                LEFT JOIN divisions d ON d.div_id = p.authors_division
                WHERE p.status IN ('approved', 'active') OR p.status IS NULL
                ORDER BY p.plan_id ASC
            ");

            $result = $query->getResultArray();
            log_message('info', 'GAD Plans retrieved: ' . count($result) . ' plans found');

            // Log the plan_ids for debugging
            $planIds = array_column($result, 'plan_id');
            log_message('info', 'Plan IDs found: ' . implode(', ', $planIds));

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error getting GAD plans: ' . $e->getMessage());

            // Fallback: try a simpler query
            try {
                $db = \Config\Database::connect();
                $query = $db->query("SELECT plan_id, activity FROM plan ORDER BY plan_id");
                $result = $query->getResultArray();

                // Add the gad_activity_id to each result
                foreach ($result as &$plan) {
                    $plan['gad_activity_id'] = 'GAD' . str_pad($plan['plan_id'], 3, '0', STR_PAD_LEFT);
                }

                log_message('info', 'Fallback query successful: ' . count($result) . ' plans found');
                return $result;
            } catch (\Exception $e2) {
                log_message('error', 'Fallback query also failed: ' . $e2->getMessage());
                return [];
            }
        }
    }

    /**
     * Get all GAD plans with complete details
     */
    public function getAllGadPlans()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("
                SELECT
                    p.plan_id,
                    p.activity,
                    p.gad_objective,
                    p.budget,
                    p.status,
                    p.authors_division,
                    p.startDate,
                    p.endDate,
                    p.created_at,
                    p.updated_at,
                    CONCAT('GAD', LPAD(p.plan_id, 3, '0')) as gad_activity_id,
                    d.division as office_name,
                    d.div_code as office_code
                FROM plan p
                LEFT JOIN divisions d ON d.div_id = p.authors_division
                ORDER BY p.plan_id ASC
            ");

            $result = $query->getResultArray();
            log_message('info', 'All GAD Plans retrieved: ' . count($result) . ' total plans');
            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error getting all GAD plans: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get GAD plan by plan_id
     */
    public function getGadPlanById($planId)
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("
                SELECT
                    p.*,
                    CONCAT('GAD', LPAD(p.plan_id, 3, '0')) as gad_activity_id,
                    d.division as office_name,
                    d.div_code as office_code
                FROM plan p
                LEFT JOIN divisions d ON d.div_id = p.authors_division
                WHERE p.plan_id = ?
            ", [$planId]);

            $result = $query->getRowArray();
            if ($result) {
                log_message('info', 'GAD Plan found for ID: ' . $planId);
            } else {
                log_message('warning', 'No GAD Plan found for ID: ' . $planId);
            }
            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error getting GAD plan by ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get divisions for dropdown
     */
    public function getDivisions()
    {
        try {
            $db = \Config\Database::connect();
            return $db->table('divisions')->get()->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error getting divisions: ' . $e->getMessage());
            return [];
        }
    }
}
