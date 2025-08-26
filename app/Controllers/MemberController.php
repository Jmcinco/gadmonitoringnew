<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\MemberModel;
use App\Models\AuditTrailModel;
use App\Models\DivisionModel;
use App\Models\OutputModel;
use App\Traits\DivisionAccessTrait;

class MemberController extends BaseController
{
    use DivisionAccessTrait;

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
        $userDivisionId = $this->getUserDivisionId();

        // Total GAD Plans (filtered by division unless admin)
        $totalPlansBuilder = $db->table('plan')->where('status !=', 'Draft');
        $this->applyDivisionFilter($totalPlansBuilder, 'plan');
        $totalPlans = $totalPlansBuilder->countAllResults();

        // Plans pending review (not yet reviewed by this member, filtered by division)
        $pendingPlansBuilder = $db->table('plan')
            ->where('status', 'Pending')
            ->orWhere('status', 'Submitted');
        $this->applyDivisionFilter($pendingPlansBuilder, 'plan');
        $pendingPlans = $pendingPlansBuilder->countAllResults();

        // Plans approved by this member (filtered by division)
        $approvedPlansBuilder = $db->table('plan')
            ->where('approved_by', $userId);
        $this->applyDivisionFilter($approvedPlansBuilder, 'plan');
        $approvedPlans = $approvedPlansBuilder->countAllResults();

        // Plans returned by this member (filtered by division)
        $returnedPlansBuilder = $db->table('plan')
            ->where('returned_by', $userId);
        $this->applyDivisionFilter($returnedPlansBuilder, 'plan');
        $returnedPlans = $returnedPlansBuilder->countAllResults();

        // Recent plans for review (last 10, filtered by division)
        $recentPlansBuilder = $db->table('plan p')
            ->select('p.*, d.division')
            ->join('divisions d', 'p.authors_division = d.div_id', 'left')
            ->where('p.status !=', 'Draft');
        $this->applyDivisionFilter($recentPlansBuilder, 'p');
        $recentPlans = $recentPlansBuilder
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

        // Get all GAD plans with division and review information (filtered by division)
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

        // Apply division filter unless user is admin
        $this->applyDivisionFilter($builder, 'p');

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

        // Add specific reviewer fields based on status
        if ($status === 'returned') {
            $data['returned_by'] = $this->session->get('user_id');
            $data['returned_at'] = date('Y-m-d H:i:s');
        } elseif ($status === 'approved') {
            $data['approved_by'] = $this->session->get('user_id');
            $data['approved_at'] = date('Y-m-d H:i:s');
        }

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

        $planId = $this->request->getPost('reviewPlanId') ?: $this->request->getPost('planId');
        $status = $this->request->getPost('reviewStatus') ?: $this->request->getPost('status');
        $remarks = $this->request->getPost('reviewRemarks') ?: $this->request->getPost('remarks');

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

            // Validate user exists in employees table
            if ($userId) {
                $userExists = $db->table('employees')->where('emp_id', $userId)->countAllResults();
                if (!$userExists) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Invalid user session']);
                }
            }

            switch (strtolower($status)) {
                case 'approved':
                    if ($userId) {
                        $data['approved_by'] = $userId;
                        $data['approved_at'] = $currentDateTime;
                    }
                    break;
                case 'returned':
                    if ($userId) {
                        $data['returned_by'] = $userId;
                        $data['returned_at'] = $currentDateTime;
                    }
                    break;
                case 'pending':
                case 'in review':
                    if ($userId) {
                        $data['reviewed_by'] = $userId;
                        $data['reviewed_at'] = $currentDateTime;
                    }
                    break;
            }

            $result = $db->table('plan')->where('plan_id', $planId)->update($data);

            if ($result) {
                // Log audit trail
                $auditModel = new AuditTrailModel();
                $statusMessage = "Plan status updated to: $status";

                $auditModel->logActivity([
                    'user_id' => $userId,
                    'action' => 'UPDATE',
                    'table_name' => 'plan',
                    'record_id' => $planId,
                    'details' => "$statusMessage by Member",
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

        try {
            // Get user division ID for filtering
            $userDivisionId = $this->session->get('div_id');

            $db = \Config\Database::connect();
            $builder = $db->table('plan p');
            $builder->select('p.*, d.division as office_name,
                             COALESCE(SUM(b.amount), 0) as budget_allocation,
                             GROUP_CONCAT(DISTINCT sf.source_name SEPARATOR ", ") as source_of_fund');
            $builder->join('divisions d', 'p.authors_division = d.div_id', 'left');
            $builder->join('budget b', 'p.plan_id = b.plan_id', 'left');
            $builder->join('source_of_fund sf', 'b.src_id = sf.src_id', 'left');
            $builder->where('p.plan_id', $id);

            // Filter by user's division only
            $builder->where('p.authors_division', $userDivisionId);

            $builder->groupBy('p.plan_id');

            $plan = $builder->get()->getRowArray();

            if (!$plan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'GAD Plan not found or access denied.'
                ])->setStatusCode(404);
            }

            // Process the responsible_units JSON field for display
            if (!empty($plan['responsible_units'])) {
                $responsibleUnits = json_decode($plan['responsible_units'], true);
                if (is_array($responsibleUnits)) {
                    $plan['responsible_units_display'] = implode(', ', $responsibleUnits);
                } else {
                    $plan['responsible_units_display'] = $plan['responsible_units'];
                }
            } else {
                $plan['responsible_units_display'] = 'Not specified';
            }

            return $this->response->setJSON([
                'success' => true,
                'plan' => $plan
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member getGadPlan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error'
            ])->setStatusCode(500);
        }
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

    /**
     * Plan Preparation - View Only for Members
     * Members can view all GAD plans but cannot create or edit them
     */
    public function planPreparation()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to('/login');
        }

        try {
            // Get user division ID for filtering (same as Focal)
            $userDivisionId = $this->session->get('div_id');

            // Get user information for the view
            $data = [
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name'),
                'role_name' => $this->session->get('role_name'),
                'division_name' => $this->session->get('division_name'),
                'gadPlans' => []
            ];

            // Get GAD plans filtered by user's division (same as Focal)
            $focalModel = new \App\Models\FocalModel();
            $gadPlans = $focalModel->getGadPlansWithAmount($userDivisionId);

            if ($gadPlans) {
                $data['gadPlans'] = $gadPlans;
            }

            return view('Member/PlanPreparation', $data);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member planPreparation: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'An error occurred while loading GAD plans.');
            return redirect()->to('/MemberDashboard');
        }
    }

    /**
     * Get GAD Plans for AJAX requests
     */
    public function getGadPlans()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            // Get user division ID for filtering (same as Focal)
            $userDivisionId = $this->session->get('div_id');

            $focalModel = new \App\Models\FocalModel();
            $gadPlans = $focalModel->getGadPlansWithAmount($userDivisionId);

            return $this->response->setJSON([
                'success' => true,
                'data' => $gadPlans
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member getGadPlans: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error']);
        }
    }

    /**
     * View GAD Plan Details (Read-only)
     */
    public function viewGadPlan($planId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            // Get user division ID for filtering (same as Focal)
            $userDivisionId = $this->session->get('div_id');

            $focalModel = new \App\Models\FocalModel();
            $divisionPlans = $focalModel->getGadPlansWithAmount($userDivisionId);

            // Find the specific plan within user's division
            $plan = null;
            foreach ($divisionPlans as $p) {
                if ($p['plan_id'] == $planId) {
                    $plan = $p;
                    break;
                }
            }

            if (!$plan) {
                return $this->response->setJSON(['success' => false, 'message' => 'Plan not found or access denied']);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $plan
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member viewGadPlan: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error']);
        }
    }

    /**
     * Get Attachments for a GAD Plan
     */
    public function getAttachments($planId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            // Get user division ID for filtering (same as Focal)
            $userDivisionId = $this->session->get('div_id');

            $focalModel = new \App\Models\FocalModel();
            $divisionPlans = $focalModel->getGadPlansWithAmount($userDivisionId);

            // Find the specific plan within user's division
            $plan = null;
            foreach ($divisionPlans as $p) {
                if ($p['plan_id'] == $planId) {
                    $plan = $p;
                    break;
                }
            }

            if (!$plan) {
                return $this->response->setJSON(['success' => false, 'message' => 'Plan not found or access denied']);
            }

            $attachments = [];
            if (!empty($plan['file_attachments'])) {
                $fileAttachments = json_decode($plan['file_attachments'], true);
                if (is_array($fileAttachments)) {
                    foreach ($fileAttachments as $file) {
                        $attachments[] = [
                            'filename' => basename($file),
                            'url' => base_url('Uploads/' . basename($file))
                        ];
                    }
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $attachments
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member getAttachments: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error']);
        }
    }

    /**
     * Budget Crafting - View Only for Members
     */
    public function budgetCrafting()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to('/login');
        }

        try {
            // Get user division ID for filtering (same as Focal)
            $userDivisionId = $this->session->get('div_id');

            $data = [
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name'),
                'role_name' => $this->session->get('role_name'),
                'division_name' => $this->session->get('division_name'),
                'budgetItems' => []
            ];

            // Get budget items filtered by user's division
            $budgetModel = new \App\Models\BudgetModel();
            $budgetItems = $budgetModel->getBudgetItems($userDivisionId);

            if ($budgetItems && is_array($budgetItems) && count($budgetItems) > 0) {
                $data['budgetItems'] = $budgetItems;
            }

            return view('Member/BudgetCrafting', $data);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member budgetCrafting: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'An error occurred while loading budget crafting.');
            return redirect()->to('/MemberDashboard');
        }
    }

    /**
     * Get Budget Items for a GAD Plan (View Only)
     */
    public function getBudgetItems($planId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            // Get user division ID for filtering (same as Focal)
            $userDivisionId = $this->session->get('div_id');

            $budgetModel = new \App\Models\BudgetModel();

            // First check if the plan belongs to user's division
            $focalModel = new \App\Models\FocalModel();
            $divisionPlans = $focalModel->getGadPlansWithAmount($userDivisionId);

            $planExists = false;
            foreach ($divisionPlans as $plan) {
                if ($plan['plan_id'] == $planId) {
                    $planExists = true;
                    break;
                }
            }

            if (!$planExists) {
                return $this->response->setJSON(['success' => false, 'message' => 'Plan not found or access denied']);
            }

            // Get budget items for the plan (filtered by division)
            $allBudgetItems = $budgetModel->getBudgetItems($userDivisionId);

            // Filter to only items for this specific plan
            $budgetItems = array_filter($allBudgetItems, function($item) use ($planId) {
                return $item['plan_id'] == $planId;
            });

            return $this->response->setJSON([
                'success' => true,
                'data' => $budgetItems
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member getBudgetItems: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error']);
        }
    }

    /**
     * Get Budget Item Details (View Only)
     */
    public function getBudgetItemDetails($actId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            // Get user division ID for filtering
            $userDivisionId = $this->session->get('div_id');

            $budgetModel = new \App\Models\BudgetModel();

            // Get all budget items for user's division
            $budgetItems = $budgetModel->getBudgetItems($userDivisionId);

            // Find the specific budget item
            $budgetItem = null;
            foreach ($budgetItems as $item) {
                if ($item['act_id'] == $actId) {
                    $budgetItem = $item;
                    break;
                }
            }

            if (!$budgetItem) {
                return $this->response->setJSON(['success' => false, 'message' => 'Budget item not found or access denied']);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $budgetItem
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member getBudgetItemDetails: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error']);
        }
    }

    /**
     * Consolidated Plan - View Only for Members
     */
    public function consolidatedPlan()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to('/login');
        }

        try {
            // Get user division ID for filtering
            $userDivisionId = $this->session->get('div_id');

            $data = [
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name'),
                'role_name' => $this->session->get('role_name'),
                'division_name' => $this->session->get('division_name'),
                'gadPlans' => [],
                'approvedPlansCount' => 0,
                'totalBudget' => 0,
                'divisionsCount' => 1 // Member only sees their own division
            ];

            // Get GAD plans with budget information filtered by user's division
            $db = \Config\Database::connect();
            $builder = $db->table('plan p');
            $builder->select('p.*, d.division as office_name,
                             COALESCE(SUM(b.amount), 0) as budget_allocation,
                             GROUP_CONCAT(DISTINCT sf.source_name SEPARATOR ", ") as source_of_fund,
                             p.responsible_units as target_beneficiaries,
                             er.first_name as reviewed_by_name, er.last_name as reviewed_by_lastname,
                             ea.first_name as approved_by_name, ea.last_name as approved_by_lastname');
            $builder->join('divisions d', 'p.authors_division = d.div_id', 'left');
            $builder->join('budget b', 'p.plan_id = b.plan_id', 'left');
            $builder->join('source_of_fund sf', 'b.src_id = sf.src_id', 'left');
            $builder->join('employees er', 'p.reviewed_by = er.emp_id', 'left');
            $builder->join('employees ea', 'p.approved_by = ea.emp_id', 'left');

            // Filter by user's division only
            $builder->where('p.authors_division', $userDivisionId);

            $builder->groupBy('p.plan_id');
            $builder->orderBy('p.plan_id', 'DESC');

            $gadPlans = $builder->get()->getResultArray();

            // Process the responsible_units JSON field for display
            foreach ($gadPlans as &$plan) {
                if (!empty($plan['target_beneficiaries'])) {
                    $responsibleUnits = json_decode($plan['target_beneficiaries'], true);
                    if (is_array($responsibleUnits)) {
                        $plan['target_beneficiaries'] = implode(', ', $responsibleUnits);
                    }
                } else {
                    $plan['target_beneficiaries'] = 'Not specified';
                }

                // Ensure source_of_fund has a default value
                if (empty($plan['source_of_fund'])) {
                    $plan['source_of_fund'] = 'Not specified';
                }
            }

            if ($gadPlans) {
                // Filter only approved plans
                $approvedPlans = array_filter($gadPlans, function($plan) {
                    return strtolower($plan['status']) === 'approved';
                });

                $data['gadPlans'] = $gadPlans;
                $data['approvedPlansCount'] = count($approvedPlans);
                $data['totalBudget'] = array_sum(array_map(function($plan) {
                    return $plan['budget_allocation'] ?? 0;
                }, $approvedPlans));
            }

            return view('Member/ConsolidatedPlan', $data);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member consolidatedPlan: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'An error occurred while loading consolidated plan.');
            return redirect()->to('/MemberDashboard');
        }
    }

    /**
     * Accomplishment Submission for Members
     */
    public function accomplishmentSubmission()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to('/login');
        }

        try {
            $data = [
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name'),
                'role_name' => $this->session->get('role_name'),
                'division_name' => $this->session->get('division_name')
            ];

            return view('Member/AccomplishmentSubmission', $data);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member accomplishmentSubmission: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'An error occurred while loading accomplishment submission.');
            return redirect()->to('/MemberDashboard');
        }
    }

    /**
     * Monitoring & Evaluation for Members
     */
    public function monitoringEvaluation()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to('/login');
        }

        try {
            $data = [
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name'),
                'role_name' => $this->session->get('role_name'),
                'division_name' => $this->session->get('division_name')
            ];

            return view('Member/MonitoringEvaluation', $data);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member monitoringEvaluation: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'An error occurred while loading monitoring & evaluation.');
            return redirect()->to('/MemberDashboard');
        }
    }

    /**
     * Get Monitoring Data for AJAX requests
     */
    public function getMonitoringData()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            // This would fetch monitoring data
            // Implementation depends on your monitoring model structure
            return $this->response->setJSON([
                'success' => true,
                'data' => [],
                'message' => 'Monitoring data functionality to be implemented'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Exception in Member getMonitoringData: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error']);
        }
    }
}
