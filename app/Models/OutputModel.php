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
        // TODO: Add these fields after database migration
        // 'reviewed_at',
        // 'submitted_at'
    ];

    protected $validationRules = [
        'plan_id' => 'required|is_natural_no_zero',
        'accomplishment' => 'required|min_length[3]',
        'status' => 'permit_empty|in_list[pending,completed,failed,approved,returned,under review]'
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
            'in_list' => 'Status must be one of: pending, completed, failed, approved, returned, under review'
        ]
    ];

    /**
     * Get accomplishments with related plan and division data
     */
    public function getAccomplishmentsWithDetails($userId = null)
    {
        try {
            $db = \Config\Database::connect();

            // Build the query with optional user filter
            $sql = "
                SELECT
                    o.*,
                    p.activity as gad_activity,
                    p.authors_division,
                    p.responsible_units,
                    p.budget as plan_budget,
                    d.division as office_name,
                    er.first_name as reviewed_by_name,
                    er.last_name as reviewed_by_lastname,
                    dr.division as reviewed_by_division,
                    COALESCE(SUM(b.amount), 0) as budget_allocation,
                    GROUP_CONCAT(DISTINCT sf.source_name SEPARATOR ', ') as source_of_fund
                FROM output o
                LEFT JOIN plan p ON p.plan_id = o.plan_id
                LEFT JOIN divisions d ON d.div_id = p.authors_division
                LEFT JOIN employees er ON o.accepted_by = er.emp_id
                LEFT JOIN divisions dr ON er.div_id = dr.div_id
                LEFT JOIN budget b ON b.plan_id = p.plan_id
                LEFT JOIN source_of_fund sf ON sf.src_id = b.src_id
            ";

            if ($userId) {
                $sql .= " WHERE o.accepted_by = " . intval($userId);
            }

            $sql .= " GROUP BY o.output_id ORDER BY o.date_accomplished DESC, o.timestamp DESC";

            $query = $db->query($sql);
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
                    'office_name' => $row['office_name'],
                    'reviewed_by_name' => $row['reviewed_by_name'],
                    'reviewed_by_lastname' => $row['reviewed_by_lastname'],
                    'reviewed_by_division' => $row['reviewed_by_division'],
                    'responsible_units' => $row['responsible_units'],
                    'budget_allocation' => $row['budget_allocation'],
                    'source_of_fund' => $row['source_of_fund'],
                    'plan_budget' => $row['plan_budget']
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
                    d.division as office_name,
                    e.first_name as reviewed_by_first_name,
                    e.last_name as reviewed_by_last_name,
                    dr.division as reviewed_by_division
                FROM output o
                LEFT JOIN plan p ON p.plan_id = o.plan_id
                LEFT JOIN divisions d ON d.div_id = p.authors_division
                LEFT JOIN employees e ON e.emp_id = o.accepted_by
                LEFT JOIN divisions dr ON dr.div_id = e.div_id
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
                    'office_name' => $result['office_name'],
                    'reviewed_by_first_name' => $result['reviewed_by_first_name'],
                    'reviewed_by_last_name' => $result['reviewed_by_last_name'],
                    'reviewed_by_division' => $result['reviewed_by_division']
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
