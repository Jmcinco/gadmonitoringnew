<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\MemberModel;
use App\Models\AuditTrailModel;
use App\Models\DivisionModel;
use App\Models\OutputModel;

class MemberController extends BaseController
{
    protected $memberModel;
    protected $divisionModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->memberModel = new MemberModel();
        $this->divisionModel = new DivisionModel();
    }

    /**
     * Member Dashboard
     */
    public function dashboard()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        // Get dashboard statistics
        $db = \Config\Database::connect();
        $userId = $this->session->get('user_id');

        // Total GAD Plans
        $totalPlans = $db->table('plan')->where('status !=', 'Draft')->countAllResults();

        // Plans pending review (not yet reviewed by this member)
        $pendingPlans = $db->table('plan')
            ->where('status', 'Pending')
            ->orWhere('status', 'Submitted')
            ->countAllResults();

        // Plans approved by this member
        $approvedPlans = $db->table('plan')
            ->where('approved_by', $userId)
            ->countAllResults();

        // Plans returned by this member
        $returnedPlans = $db->table('plan')
            ->where('returned_by', $userId)
            ->countAllResults();

        // Recent plans for review (last 10)
        $recentPlans = $db->table('plan p')
            ->select('p.*, d.division')
            ->join('divisions d', 'p.authors_division = d.div_id', 'left')
            ->where('p.status !=', 'Draft')
            ->orderBy('p.created_at', 'DESC')
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
            'recentPlans' => $recentPlans
        ];

        return view('MemberDashboard', $data);
    }

    /**
     * GAD Plan Review Page
     */
    public function planReview()
    {
        // Enhanced authentication check with debugging
        $isLoggedIn = $this->session->get('isLoggedIn');
        $roleId = $this->session->get('role_id');
        $userId = $this->session->get('user_id');

        // Debug session data
        log_message('debug', 'MemberController::planReview - Session data: ' . json_encode([
            'isLoggedIn' => $isLoggedIn,
            'role_id' => $roleId,
            'user_id' => $userId,
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ]));

        if (!$isLoggedIn) {
            $this->session->setFlashdata('error', 'Please log in to access this page.');
            return redirect()->to(base_url('/login'));
        }

        if ($roleId != 2) {
            $this->session->setFlashdata('error', 'Access denied. This page is for Members only. Your role ID: ' . $roleId);
            // Redirect based on role
            switch ($roleId) {
                case 1: // Focal
                    return redirect()->to(base_url('/FocalDashboard'));
                case 3: // Secretariat
                    return redirect()->to(base_url('/SecretariatDashboard'));
                case 4: // Administrator
                    return redirect()->to(base_url('/AdminDashboard'));
                default:
                    return redirect()->to(base_url('/login'));
            }
        }

        $focalModel = new \App\Models\MemberModel();

        // Get all GAD plans with division and review information
        $db = \Config\Database::connect();
        $builder = $db->table('plan p');
        $builder->select('p.*, d.division,
                         er.first_name as reviewed_by_name, er.last_name as reviewed_by_lastname,
                         ea.first_name as approved_by_name, ea.last_name as approved_by_lastname,
                         eret.first_name as returned_by_name, eret.last_name as returned_by_lastname');
        $builder->join('divisions d', 'p.authors_division = d.div_id', 'left');
        $builder->join('employees er', 'p.reviewed_by = er.emp_id', 'left');
        $builder->join('employees ea', 'p.approved_by = ea.emp_id', 'left');
        $builder->join('employees eret', 'p.returned_by = eret.emp_id', 'left');
        $builder->where('p.status !=', 'Draft'); // Only show non-draft plans
        $builder->orderBy('p.plan_id', 'DESC');

        $gadPlans = $builder->get()->getResultArray();

        $data = [
            'gadPlans' => $gadPlans,
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];

        return view('Member/PlanReview', $data);
    }
    /**
     * Review GAD Plan (Approve/Return/Pending)
     */
    public function reviewPlan()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
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
        $oldPlan = $this->memberModel->find($planId);
        if (!$oldPlan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'GAD Plan not found.'
            ])->setStatusCode(404);
        }

        $data = [
            'status' => $status,
            'remarks' => $remarks,
            'reviewed_by' => $this->session->get('user_id'),
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        if ($this->memberModel->update($planId, $data)) {
            // Log audit trail for GAD Plan review
            $auditModel = new AuditTrailModel();
            $planTitle = $oldPlan['activity'] ?? 'GAD Plan';
            $reviewAction = '';
            
            switch ($status) {
                case 'approved':
                    $reviewAction = 'approved';
                    break;
                case 'returned':
                    $reviewAction = 'returned for revision';
                    break;
                case 'pending':
                    $reviewAction = 'marked as pending';
                    break;
                default:
                    $reviewAction = 'reviewed';
            }
            
            $auditModel->logActivity([
                'user_id' => $this->session->get('user_id'),
                'action' => 'UPDATE',
                'table_name' => 'plan',
                'record_id' => $planId,
                'employee_name' => $planTitle,
                'employee_email' => $this->session->get('email'),
                'details' => 'GAD Plan ' . $reviewAction . ' by Member: ' . $planTitle . ($remarks ? ' - ' . $remarks : ''),
                'old_data' => $oldPlan,
                'new_data' => array_merge($oldPlan, $data)
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'GAD Plan review completed successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update GAD Plan status.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Update Plan Status (Approve/Return/Pending)
     */
    public function updateStatus()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        $planId = $this->request->getPost('planId');
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');

        if (!$planId || !$status) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing required fields']);
        }

        try {
            $db = \Config\Database::connect();

            // Prepare data based on the action being taken
            $data = [
                'status' => $status,
                'remarks' => $remarks
            ];

            // Set appropriate reviewer fields based on status
            $currentDateTime = date('Y-m-d H:i:s');
            $userId = $this->session->get('user_id');

            switch (strtolower($status)) {
                case 'approved':
                    $data['approved_by'] = $userId;
                    $data['approved_at'] = $currentDateTime;
                    break;
                case 'returned':
                    $data['returned_by'] = $userId;
                    $data['returned_at'] = $currentDateTime;
                    break;
                case 'pending':
                case 'in review':
                    $data['reviewed_by'] = $userId;
                    $data['reviewed_at'] = $currentDateTime;
                    break;
            }

            $result = $db->table('plan')->where('plan_id', $planId)->update($data);

            if ($result) {
                // Log audit trail
                $auditModel = new AuditTrailModel();
                $auditModel->logActivity([
                    'user_id' => $userId,
                    'action' => 'UPDATE',
                    'table_name' => 'plan',
                    'record_id' => $planId,
                    'details' => "Plan status updated to: $status by Member",
                    'old_data' => null,
                    'new_data' => $data
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Plan status updated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update plan status'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error updating plan status: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while updating the plan'
            ]);
        }
    }

    /**
     * Get GAD Plan details for review
     */
    public function getGadPlan($id)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $plan = $this->memberModel->find($id);
        if (!$plan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'GAD Plan not found.'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'success' => true,
            'plan' => $plan
        ]);
    }

    /**
     * Get Plan Details for Modal Display
     */
    public function getPlanDetails($planId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            $db = \Config\Database::connect();
            $plan = $db->table('plan p')
                ->select('p.*, d.division')
                ->join('divisions d', 'p.authors_division = d.div_id', 'left')
                ->where('p.plan_id', $planId)
                ->get()
                ->getRowArray();

            if ($plan) {
                return $this->response->setJSON(['success' => true, 'plan' => $plan]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Plan not found']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error fetching plan details: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error fetching plan details']);
        }
    }

    /**
     * Reports Page
     */
    public function reports()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];

        return view('Member/Reports', $data);
    }

    /**
     * Profile Page
     */
    public function profile()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];

        return view('Member/Profile', $data);
    }



    /**
     * Accomplishment Submission Page for GAD Members
     */
    public function reviewApproval()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        try {
            $outputModel = new OutputModel();
            $memberModel = new \App\Models\MemberModel();

            // Get all submitted accomplishments for review (not just user's own)
            $accomplishments = $outputModel->getAccomplishmentsWithDetails();

            // Filter to show only submitted accomplishments (not drafts)
            $accomplishments = array_filter($accomplishments, function($acc) {
                return in_array(strtolower($acc['status']), ['completed', 'under review', 'approved', 'returned']);
            });

            log_message('info', 'Member reviewApproval - Accomplishments count: ' . count($accomplishments));
            log_message('info', 'Member reviewApproval - Sample accomplishment: ' . json_encode($accomplishments[0] ?? 'No accomplishments'));

            // Get available GAD plans for the dropdown
            $gadPlans = $memberModel->getGadPlans();
            log_message('info', 'Member reviewApproval - GAD Plans count: ' . count($gadPlans));

            $data = [
                'accomplishments' => $accomplishments,
                'gadPlans' => $gadPlans,
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name')
            ];

            return view('Member/ReviewApproval', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in Member reviewApproval: ' . $e->getMessage());

            $data = [
                'accomplishments' => [],
                'gadPlans' => [],
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name')
            ];

            return view('Member/ReviewApproval', $data);
        }
    }

    /**
     * Save new accomplishment
     */
    public function saveAccomplishment()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $outputModel = new OutputModel();

        $data = [
            'plan_id' => $this->request->getPost('planId'),
            'accomplishment' => $this->request->getPost('accomplishment'),
            'date_accomplished' => $this->request->getPost('dateAccomplished'),
            'status' => $this->request->getPost('status'),
            'remarks' => $this->request->getPost('remarks'),
            'accepted_by' => $this->session->get('user_id'),
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Handle file upload
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if ($file->move(WRITEPATH . '../public/uploads', $newName)) {
                $data['file'] = $newName;
            }
        }

        if ($outputModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Accomplishment saved successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to save accomplishment.'
            ]);
        }
    }

    /**
     * Update existing accomplishment
     */
    public function updateAccomplishment()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $outputModel = new OutputModel();
        $outputId = $this->request->getPost('accomplishmentId');

        $data = [
            'plan_id' => $this->request->getPost('planId'),
            'accomplishment' => $this->request->getPost('accomplishment'),
            'date_accomplished' => $this->request->getPost('dateAccomplished'),
            'status' => $this->request->getPost('status'),
            'remarks' => $this->request->getPost('remarks'),
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Handle file upload
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if ($file->move(WRITEPATH . '../public/uploads', $newName)) {
                $data['file'] = $newName;
            }
        }

        if ($outputModel->update($outputId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Accomplishment updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update accomplishment.'
            ]);
        }
    }

    /**
     * Delete accomplishment
     */
    public function deleteAccomplishment($outputId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $outputModel = new OutputModel();

        if ($outputModel->delete($outputId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Accomplishment deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete accomplishment.'
            ]);
        }
    }




    public function reviewAccomplishment()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $outputId = $this->request->getPost('outputId');
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks') ?? '';

        if (!$outputId || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Output ID and status are required.'
            ])->setStatusCode(400);
        }

        try {
            $outputModel = new OutputModel();

            // Get old accomplishment data for audit trail
            $oldAccomplishment = $outputModel->find($outputId);
            if (!$oldAccomplishment) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Accomplishment not found.'
                ])->setStatusCode(404);
            }

            // Map status to database values
            $dbStatus = match(strtolower($status)) {
                'approved' => 'approved',
                'returned' => 'returned',
                'under review' => 'under review',
                default => strtolower($status)
            };

            $data = [
                'status' => $dbStatus,
                'remarks' => $remarks,
                'accepted_by' => $this->session->get('user_id'),
                // TODO: Add reviewed_at after database migration
                // 'reviewed_at' => date('Y-m-d H:i:s'),
                'timestamp' => date('Y-m-d H:i:s')
            ];

            if ($outputModel->update($outputId, $data)) {
                // Log audit trail for accomplishment review
                $auditModel = new AuditTrailModel();
                $accomplishmentTitle = $oldAccomplishment['accomplishment'] ?? 'GAD Accomplishment';
                $reviewAction = match(strtolower($status)) {
                    'approved' => 'approved',
                    'returned' => 'returned for revision',
                    'under review' => 'marked as under review',
                    default => 'reviewed'
                };

                $auditModel->logActivity([
                    'user_id' => $this->session->get('user_id'),
                    'action' => 'REVIEW',
                    'table_name' => 'output',
                    'record_id' => $outputId,
                    'employee_name' => $accomplishmentTitle,
                    'employee_email' => $this->session->get('email'),
                    'details' => 'GAD Accomplishment ' . $reviewAction . ': ' . $accomplishmentTitle . ($remarks ? ' - ' . $remarks : ''),
                    'old_data' => $oldAccomplishment,
                    'new_data' => array_merge($oldAccomplishment, $data)
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Accomplishment ' . $reviewAction . ' successfully.',
                    'accomplishment' => array_merge($oldAccomplishment, $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update accomplishment status.',
                    'validation' => $outputModel->errors()
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in Member reviewAccomplishment: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Update Accomplishment Status (Quick Actions)
     */
    public function updateAccomplishmentStatus()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        $outputId = $this->request->getPost('outputId');
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks') ?? '';

        if (!$outputId || !$status) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing required fields']);
        }

        try {
            $outputModel = new OutputModel();

            // Map status to database values
            $dbStatus = match(strtolower($status)) {
                'approved' => 'approved',
                'returned' => 'returned',
                'under review' => 'under review',
                default => strtolower($status)
            };

            $data = [
                'status' => $dbStatus,
                'remarks' => $remarks,
                'accepted_by' => $this->session->get('user_id'),
                // TODO: Add reviewed_at after database migration
                // 'reviewed_at' => date('Y-m-d H:i:s'),
                'timestamp' => date('Y-m-d H:i:s')
            ];

            if ($outputModel->update($outputId, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in Member updateAccomplishmentStatus: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    /**
     * Get Accomplishment Details
     */
    public function getAccomplishmentDetails($outputId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            $outputModel = new OutputModel();

            // Debug: Log the request
            log_message('info', 'Member getAccomplishmentDetails called with outputId: ' . $outputId);

            // First check if the record exists with a direct query
            $db = \Config\Database::connect();
            $query = $db->query("SELECT * FROM output WHERE output_id = ?", [$outputId]);
            $accomplishment = $query->getRowArray();

            // Debug: Log the result
            log_message('info', 'Direct query result: ' . json_encode($accomplishment));

            if ($accomplishment) {
                return $this->response->setJSON(['success' => true, 'accomplishment' => $accomplishment]);
            } else {
                // Check if any records exist at all
                $countQuery = $db->query("SELECT COUNT(*) as count FROM output");
                $count = $countQuery->getRowArray();
                log_message('info', 'Total records in output table: ' . json_encode($count));

                return $this->response->setJSON(['success' => false, 'message' => 'Accomplishment not found with ID: ' . $outputId . '. Total records: ' . ($count['count'] ?? 0)]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in Member getAccomplishmentDetails: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
}
