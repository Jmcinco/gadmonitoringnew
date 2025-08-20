<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\FocalModel;
use App\Models\AuditTrailModel;
use App\Models\DivisionModel;
use App\Models\MfoModel;
use App\Models\PapModel;

class SecretariatController extends BaseController
{
    protected $focalModel;
    protected $divisionModel;
    protected $mfoModel;
    protected $papModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->focalModel = new FocalModel();
        $this->divisionModel = new DivisionModel();
        $this->mfoModel = new MfoModel();
        $this->papModel = new PapModel();
    }

    public function dashboard()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 3) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        // Get dashboard statistics
        $db = \Config\Database::connect();

        // Total GAD Plans
        $totalPlans = $db->table('plan')->countAllResults();

        // Plans by status
        $pendingPlans = $db->table('plan')->where('status', 'Pending')->countAllResults();
        $approvedPlans = $db->table('plan')->where('status', 'Approved')->countAllResults();
        $returnedPlans = $db->table('plan')->where('status', 'Returned')->countAllResults();
        $finalizedPlans = $db->table('plan')->where('status', 'Finalized')->countAllResults();

        // Total divisions
        $totalDivisions = $db->table('divisions')->countAllResults();

        // Total employees
        $totalEmployees = $db->table('employees')->countAllResults();

        // Recent activities (last 10)
        $recentActivities = $db->table('audit_trail at')
            ->select('at.*, e.first_name, e.last_name')
            ->join('employees e', 'at.user_id = e.emp_id', 'left')
            ->orderBy('at.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name'),
            'totalPlans' => $totalPlans,
            'pendingPlans' => $pendingPlans,
            'approvedPlans' => $approvedPlans,
            'returnedPlans' => $returnedPlans,
            'finalizedPlans' => $finalizedPlans,
            'totalDivisions' => $totalDivisions,
            'totalEmployees' => $totalEmployees,
            'recentActivities' => $recentActivities
        ];

        return view('/SecretariatDashboard', $data);
    }

    /**
     * Final Review GAD Plan (Finalize/Return)
     */
    public function finalizePlan()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 3) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $planId = $this->request->getPost('planId');
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks') ?? '';

        if (!$planId || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Plan ID and status are required.'
            ])->setStatusCode(400);
        }

        // Get old plan data for audit trail
        $oldPlan = $this->focalModel->find($planId);
        if (!$oldPlan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'GAD Plan not found.'
            ])->setStatusCode(404);
        }

        $data = [
            'status' => $status,
            'remarks' => $remarks,
            'finalized_by' => $this->session->get('user_id'),
            'finalized_at' => date('Y-m-d H:i:s')
        ];

        if ($this->focalModel->update($planId, $data)) {
            // Log audit trail for GAD Plan finalization
            $auditModel = new AuditTrailModel();
            $planTitle = 'GAD Plan - ' . substr($oldPlan['issue_mandate'], 0, 50);
            $finalAction = '';

            switch ($status) {
                case 'finalized':
                    $finalAction = 'finalized';
                    break;
                case 'returned':
                    $finalAction = 'returned for revision';
                    break;
                case 'rejected':
                    $finalAction = 'rejected';
                    break;
                default:
                    $finalAction = 'processed';
            }

            $auditModel->logActivity([
                'user_id' => $this->session->get('user_id'),
                'action' => 'UPDATE',
                'table_name' => 'plan',
                'record_id' => $planId,
                'employee_name' => $planTitle,
                'employee_email' => $this->session->get('email'),
                'details' => 'GAD Plan ' . $finalAction . ' by Secretariat: ' . $planTitle . ($remarks ? ' - ' . $remarks : ''),
                'old_data' => $oldPlan,
                'new_data' => array_merge($oldPlan, $data)
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'GAD Plan finalization completed successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to finalize GAD Plan.'
            ])->setStatusCode(500);
        }
    }
}