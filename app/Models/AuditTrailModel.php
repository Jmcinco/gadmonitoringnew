<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditTrailModel extends Model
{
    protected $table = 'audit_trail';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'action',
        'table_name',
        'record_id',
        'employee_name',
        'employee_email',
        'details',
        'ip_address',
        'user_agent',
        'old_data',
        'new_data'
    ];

    protected $validationRules = [
        'user_id' => 'required|integer',
        'action' => 'required|in_list[CREATE,UPDATE,DELETE,LOGIN,LOGOUT,REVIEW,APPROVE,REJECT,FINALIZE,ARCHIVE]',
        'table_name' => 'required|max_length[100]',
        'details' => 'required|max_length[1000]',
        'ip_address' => 'permit_empty|valid_ip'
    ];

    /**
     * Get audit logs with user information
     */
    public function getAuditLogsWithUsers($action = null, $limit = 100, $offset = 0)
    {
        $builder = $this->db->table($this->table . ' a');
        $builder->select('a.*, e.first_name, e.last_name, a.created_at as timestamp');
        $builder->join('employees e', 'e.emp_id = a.user_id', 'left');
        
        if ($action && $action !== 'All') {
            $builder->where('a.action', $action);
        }
        
        $builder->orderBy('a.created_at', 'DESC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get audit logs count
     */
    public function getAuditLogsCount($action = null)
    {
        $builder = $this->db->table($this->table);
        
        if ($action && $action !== 'All') {
            $builder->where('action', $action);
        }
        
        return $builder->countAllResults();
    }

    /**
     * Log an audit entry
     */
    public function logActivity($data)
    {
        // Get user ID from multiple possible sources
        $userId = $data['user_id'] ?? session()->get('user_id') ?? session()->get('emp_id') ?? null;

        $auditData = [
            'user_id' => $userId,
            'action' => $data['action'],
            'table_name' => $data['table_name'] ?? 'employees',
            'record_id' => $data['record_id'] ?? null,
            'employee_name' => $data['employee_name'] ?? '',
            'employee_email' => $data['employee_email'] ?? '',
            'details' => $data['details'],
            'ip_address' => $data['ip_address'] ?? $this->getClientIP(),
            'user_agent' => $data['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? '',
            'old_data' => isset($data['old_data']) ? json_encode($data['old_data']) : null,
            'new_data' => isset($data['new_data']) ? json_encode($data['new_data']) : null
        ];

        // Debug logging
        log_message('debug', 'Audit Trail - User ID: ' . ($userId ?? 'NULL') . ', Action: ' . $data['action']);
        log_message('debug', 'Audit Trail - Session data: ' . json_encode([
            'user_id' => session()->get('user_id'),
            'emp_id' => session()->get('emp_id'),
            'isLoggedIn' => session()->get('isLoggedIn')
        ]));

        return $this->insert($auditData);
    }

    /**
     * Get client IP address
     */
    private function getClientIP()
    {
        $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Get recent activities for dashboard
     */
    public function getRecentActivities($limit = 10)
    {
        return $this->getAuditLogsWithUsers(null, $limit, 0);
    }

    /**
     * Get activity statistics
     */
    public function getActivityStats()
    {
        $builder = $this->db->table($this->table);
        
        $stats = [
            'total' => $builder->countAllResults(),
            'today' => $builder->where('DATE(created_at)', date('Y-m-d'))->countAllResults(),
            'this_week' => $builder->where('created_at >=', date('Y-m-d', strtotime('-7 days')))->countAllResults(),
            'this_month' => $builder->where('created_at >=', date('Y-m-d', strtotime('-30 days')))->countAllResults()
        ];

        // Get action breakdown
        $builder = $this->db->table($this->table);
        $actionStats = $builder->select('action, COUNT(*) as count')
                              ->groupBy('action')
                              ->get()
                              ->getResultArray();

        $stats['actions'] = [];
        foreach ($actionStats as $action) {
            $stats['actions'][$action['action']] = $action['count'];
        }

        return $stats;
    }
}
