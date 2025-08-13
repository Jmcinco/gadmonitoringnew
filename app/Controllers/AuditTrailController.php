<?php

namespace App\Controllers;

use App\Models\AuditTrailModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuditTrailController extends BaseController
{
    protected $auditModel;
    protected $session;

    public function __construct()
    {
        $this->auditModel = new AuditTrailModel();
        $this->session = session();
    }

    /**
     * Display audit trail page
     */
    public function index()
    {
        // Check if user is logged in (accessible to all authenticated users)
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in to access the audit trail.');
        }

        $action = $this->request->getGet('action') ?? 'All';
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        // Get audit logs
        $auditLogs = $this->auditModel->getAuditLogsWithUsers($action, $perPage, $offset);
        $totalLogs = $this->auditModel->getAuditLogsCount($action);

        // Format timestamps
        foreach ($auditLogs as &$log) {
            $log['timestamp'] = date('M d, Y H:i:s', strtotime($log['timestamp']));
        }

        $data = [
            'title' => 'Audit Trail',
            'audit_logs' => $auditLogs,
            'current_action' => $action,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($totalLogs / $perPage),
                'total_records' => $totalLogs,
                'per_page' => $perPage
            ]
        ];

        return view('Admin/AuditTrail', $data);
    }

    /**
     * Get audit logs via AJAX
     */
    public function getAuditLogs()
    {
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Authentication required']);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $action = $this->request->getPost('action') ?? 'All';
        $page = (int)($this->request->getPost('page') ?? 1);
        $perPage = (int)($this->request->getPost('per_page') ?? 50);
        $offset = ($page - 1) * $perPage;

        $auditLogs = $this->auditModel->getAuditLogsWithUsers($action, $perPage, $offset);
        $totalLogs = $this->auditModel->getAuditLogsCount($action);

        // Format timestamps
        foreach ($auditLogs as &$log) {
            $log['timestamp'] = date('M d, Y H:i:s', strtotime($log['timestamp']));
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $auditLogs,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($totalLogs / $perPage),
                'total_records' => $totalLogs,
                'per_page' => $perPage
            ]
        ]);
    }

    /**
     * Export audit logs to CSV
     */
    public function exportCSV()
    {
        // Check if user is logged in (accessible to all authenticated users)
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in to export audit logs.');
        }

        $action = $this->request->getGet('action') ?? 'All';
        $auditLogs = $this->auditModel->getAuditLogsWithUsers($action, 10000, 0); // Get all records

        $filename = 'audit_trail_' . date('Y-m-d_H-i-s') . '.csv';

        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // CSV headers
        fputcsv($output, [
            'Timestamp',
            'User ID',
            'User Name',
            'Action',
            'Employee Name',
            'Employee Email',
            'Details',
            'IP Address',
            'User Agent'
        ]);

        // CSV data
        foreach ($auditLogs as $log) {
            fputcsv($output, [
                $log['timestamp'],
                $log['user_id'],
                ($log['first_name'] ?? '') . ' ' . ($log['last_name'] ?? ''),
                $log['action'],
                $log['employee_name'],
                $log['employee_email'],
                $log['details'],
                $log['ip_address'],
                $log['user_agent']
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Get audit statistics
     */
    public function getStats()
    {
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Authentication required']);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $stats = $this->auditModel->getActivityStats();

        return $this->response->setJSON([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Clear old audit logs (older than specified days)
     * Note: This function is restricted to administrators only for security
     */
    public function clearOldLogs()
    {
        // Check admin privileges (role_id = 4) - Only admins can delete audit logs
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 4) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Admin privileges required to delete audit logs']);
        }

        $days = (int)($this->request->getPost('days') ?? 90);
        
        if ($days < 30) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cannot delete logs newer than 30 days'
            ]);
        }

        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        $builder = $this->auditModel->builder();
        $deletedCount = $builder->where('created_at <', $cutoffDate)->delete();

        // Log this action
        $this->auditModel->logActivity([
            'action' => 'DELETE',
            'table_name' => 'audit_trail',
            'details' => "Cleared {$deletedCount} audit logs older than {$days} days",
            'employee_name' => 'System Cleanup',
            'employee_email' => ''
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => "Successfully deleted {$deletedCount} old audit logs"
        ]);
    }
}
