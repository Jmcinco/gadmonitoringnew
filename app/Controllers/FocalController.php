<?php

namespace App\Controllers;
use App\Models\ObjectOfExpenseModel;
use App\Models\AuditTrailModel;
use CodeIgniter\Controller;

class FocalController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }

    public function dashboard()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];
        return view('FocalDashboard', $data);
    }

    public function planPreparation()
{
    helper('form');

    if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
        $this->session->setFlashdata('error', 'Unauthorized access.');
        return redirect()->to(base_url('/login'));
    }

    // ✅ Load database
    $db = \Config\Database::connect();

    // ✅ Fetch divisions from DB
    $divisions = $db->table('divisions')->select('div_id, division')->orderBy('division')->get()->getResult();

    $focalModel = new \App\Models\FocalModel();
    $gadPlans = $focalModel->getGadPlansWithAmount();

    // Create division lookup array for efficiency
    $divisionLookup = [];
    foreach ($divisions as $div) {
        $divisionLookup[$div->div_id] = $div->division;
    }

    // Process each plan to set the submitted_by_name
    foreach ($gadPlans as &$plan) {
        $responsibleUnits = [];
        if (!empty($plan['responsible_units'])) {
            $responsibleUnits = json_decode($plan['responsible_units'], true);
        }
        $plan['responsible_units_display'] = (is_array($responsibleUnits) && !empty($responsibleUnits))
            ? implode(', ', $responsibleUnits)
            : 'N/A';

        // Set the submitted by division - try multiple approaches
        if (!empty($plan['submitted_by_division'])) {
            // From JOIN query
            $plan['submitted_by_name'] = $plan['submitted_by_division'];
        } elseif (!empty($plan['authors_division']) && isset($divisionLookup[$plan['authors_division']])) {
            // Manual lookup using pre-loaded array
            $plan['submitted_by_name'] = $divisionLookup[$plan['authors_division']];
        } else {
            $plan['submitted_by_name'] = 'N/A';
        }
    }

    $data = [
        'gadPlans'   => $gadPlans,
        'first_name' => $this->session->get('first_name'),
        'last_name'  => $this->session->get('last_name'),
        'divisions'  => $divisions
    ];

    return view('Focal/PlanPreparation', $data);
}


public function budgetCrafting()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        $budgetModel = new \App\Models\BudgetModel();
        $objectOfExpenseModel = new \App\Models\ObjectOfExpenseModel();
        $sourceOfFundModel = new \App\Models\SourceOfFundModel();
        $focalModel = new \App\Models\FocalModel();

        $data = [
            'budgetItems' => $budgetModel->getBudgetItems(),
            'objectsOfExpense' => $objectOfExpenseModel->findAll(),
            'sourcesOfFund' => $sourceOfFundModel->findAll(),
            'plans' => $focalModel->getGadPlans(),
            'first_name' => $this->session->get('first_name') ?? 'Admin',
            'last_name' => $this->session->get('last_name') ?? 'User'
        ];

        return view('Focal/BudgetCrafting', $data);
    }

    public function addBudgetItem()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $budgetModel = new \App\Models\BudgetModel();

        $data = [
            'plan_id' => $this->request->getPost('plan_id'),
            'obj_id' => $this->request->getPost('obj_id'),
            'src_id' => $this->request->getPost('src_id'),
            'particulars' => $this->request->getPost('particulars'),
            'amount' => $this->request->getPost('amount'),
            'type_of_expense' => $this->request->getPost('expenseType')
        ];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'plan_id' => 'required|is_natural_no_zero|is_not_unique[plan.plan_id]',
            'obj_id' => 'required|is_natural_no_zero|is_not_unique[object_of_expense.obj_id]',
            'src_id' => 'required|is_natural_no_zero|is_not_unique[source_of_fund.src_id]',
            'particulars' => 'required|min_length[3]',
            'amount' => 'required|decimal|greater_than[0]',
            'type_of_expense' => 'required|in_list[Direct Expense,Appropriation]'
        ]);

        if (!$validation->run($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validation->getErrors()
            ])->setStatusCode(400);
        }

        try {
            if ($budgetModel->insert($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Budget item added successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add budget item.',
                    'errors' => $budgetModel->errors() ?: ['unknown' => 'Unknown database error']
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while saving the budget item.',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function editBudgetItem()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $budgetModel = new \App\Models\BudgetModel();
        $act_id = $this->request->getPost('act_id');

        $data = [
            'plan_id' => $this->request->getPost('plan_id'),
            'obj_id' => $this->request->getPost('obj_id'),
            'src_id' => $this->request->getPost('src_id'),
            'particulars' => $this->request->getPost('particulars'),
            'amount' => $this->request->getPost('amount'),
            'type_of_expense' => $this->request->getPost('expenseType')
        ];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'act_id' => 'required|is_natural_no_zero|is_not_unique[budget.act_id]',
            'plan_id' => 'required|is_natural_no_zero|is_not_unique[plan.plan_id]',
            'obj_id' => 'required|is_natural_no_zero|is_not_unique[object_of_expense.obj_id]',
            'src_id' => 'required|is_natural_no_zero|is_not_unique[source_of_fund.src_id]',
            'particulars' => 'required|min_length[3]',
            'amount' => 'required|decimal|greater_than[0]',
            'type_of_expense' => 'required|in_list[Direct Expense,Appropriation]'
        ]);

        $validationData = array_merge(['act_id' => $act_id], $data);

        if (!$validation->run($validationData)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validation->getErrors()
            ])->setStatusCode(400);
        }

        try {
            if ($budgetModel->update($act_id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Budget item updated successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update budget item.',
                    'errors' => $budgetModel->errors() ?: ['unknown' => 'Unknown database error']
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while updating the budget item.',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function deleteBudgetItem()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $budgetModel = new \App\Models\BudgetModel();
        $act_id = $this->request->getPost('act_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'act_id' => 'required|is_natural_no_zero|is_not_unique[budget.act_id]'
        ]);

        if (!$validation->run(['act_id' => $act_id])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validation->getErrors()
            ])->setStatusCode(400);
        }

        try {
            if ($budgetModel->delete($act_id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Budget item deleted successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete budget item.',
                    'errors' => $budgetModel->errors() ?: ['unknown' => 'Unknown database error']
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while deleting the budget item.',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function consolidatedPlan()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        return view('Focal/ConsolidatedPlan');
    }

    public function planReview()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        $focalModel = new \App\Models\FocalModel();

        // Get all GAD plans with division information
        $db = \Config\Database::connect();
        $builder = $db->table('plan p');
        $builder->select('p.*, d.division,
                         er.first_name as reviewed_by_name, er.last_name as reviewed_by_lastname, dr.division as reviewed_by_division,
                         ea.first_name as approved_by_name, ea.last_name as approved_by_lastname, da.division as approved_by_division,
                         eret.first_name as returned_by_name, eret.last_name as returned_by_lastname, dret.division as returned_by_division');
        $builder->join('divisions d', 'p.authors_division = d.div_id', 'left');
        $builder->join('employees er', 'p.reviewed_by = er.emp_id', 'left');
        $builder->join('divisions dr', 'er.div_id = dr.div_id', 'left');
        $builder->join('employees ea', 'p.approved_by = ea.emp_id', 'left');
        $builder->join('divisions da', 'ea.div_id = da.div_id', 'left');
        $builder->join('employees eret', 'p.returned_by = eret.emp_id', 'left');
        $builder->join('divisions dret', 'eret.div_id = dret.div_id', 'left');
        $builder->where('p.status !=', 'Draft'); // Only show non-draft plans
        $builder->orderBy('p.created_at', 'DESC');

        $gadPlans = $builder->get()->getResultArray();

        $data = [
            'gadPlans' => $gadPlans,
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];

        return view('Focal/PlanReview', $data);
    }

    public function reviewApproval()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];
        return view('Focal/ReviewApproval', $data);
    }

    public function accomplishmentSubmission()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        return view('Focal/AccomplishmentSubmission');
    }

    public function consolidatedAccomplishment()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        $data = [
            'first_name' => $this->session->get('first_name') ?? 'Admin', // Fallback if null
            'last_name' => $this->session->get('last_name') ?? 'User'
        ];
        return view('Focal/ConsolidatedAccomplishment', $data);
    }
    


    /**
     * Get Plan Details for Review
     */
    public function getPlanDetails($planId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        // Get plan with reviewer division information
        $db = \Config\Database::connect();
        $builder = $db->table('plan p');
        $builder->select('p.*, d.division as division_name,
                         er.first_name as reviewed_by_name, er.last_name as reviewed_by_lastname, dr.division as reviewed_by_division,
                         ea.first_name as approved_by_name, ea.last_name as approved_by_lastname, da.division as approved_by_division,
                         eret.first_name as returned_by_name, eret.last_name as returned_by_lastname, dret.division as returned_by_division');
        $builder->join('divisions d', 'p.authors_division = d.div_id', 'left');
        $builder->join('employees er', 'p.reviewed_by = er.emp_id', 'left');
        $builder->join('divisions dr', 'er.div_id = dr.div_id', 'left');
        $builder->join('employees ea', 'p.approved_by = ea.emp_id', 'left');
        $builder->join('divisions da', 'ea.div_id = da.div_id', 'left');
        $builder->join('employees eret', 'p.returned_by = eret.emp_id', 'left');
        $builder->join('divisions dret', 'eret.div_id = dret.div_id', 'left');
        $builder->where('p.plan_id', $planId);

        $plan = $builder->get()->getRowArray();

        if (!$plan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Plan not found.'
            ])->setStatusCode(404);
        }

        // Decode JSON fields
        $plan['gad_objective'] = json_decode($plan['gad_objective'] ?? '[]', true);
        $plan['responsible_units'] = json_decode($plan['responsible_units'] ?? '[]', true);
        $plan['file_attachments'] = json_decode($plan['file_attachments'] ?? '[]', true);

        return $this->response->setJSON([
            'success' => true,
            'plan' => $plan
        ]);
    }

    public function updateStatus()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $planId = $this->request->getPost('planId');
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');

        if (!$planId || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Plan ID and status are required.'
            ])->setStatusCode(400);
        }

        $focalModel = new \App\Models\FocalModel();

        // Get old data for audit trail
        $oldPlan = $focalModel->find($planId);

        if (!$oldPlan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Plan not found.'
            ])->setStatusCode(404);
        }

        $data = [
            'status' => $status,
            'remarks' => $remarks,
            'reviewed_by' => $this->session->get('user_id'),
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        if ($focalModel->update($planId, $data)) {
            // Log audit trail for GAD Plan status update
            $auditModel = new AuditTrailModel();
            $planTitle = $oldPlan['activity'] ?? 'GAD Plan';

            $auditModel->logActivity([
                'user_id' => $this->session->get('user_id'),
                'action' => 'UPDATE',
                'table_name' => 'plan',
                'record_id' => $planId,
                'employee_name' => $planTitle,
                'employee_email' => $this->session->get('email'),
                'details' => 'GAD Plan status updated to "' . $status . '": ' . $planTitle . ($remarks ? ' - ' . $remarks : ''),
                'old_data' => $oldPlan,
                'new_data' => array_merge($oldPlan, $data)
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully.',
                'plan' => array_merge($oldPlan, $data)
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status.'
            ])->setStatusCode(500);
        }
    }

    public function getAttachments()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }

        $planId = $this->request->getGet('plan');

        if (!$planId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Plan ID is required']);
        }

        $db = \Config\Database::connect();

        // Get file attachments for the specific plan
        $query = $db->table('plan')
                    ->select('file_attachments')
                    ->where('plan_id', $planId)
                    ->get();

        $result = $query->getRowArray();

        if ($result && !empty($result['file_attachments'])) {
            $attachments = json_decode($result['file_attachments'], true);

            if (is_array($attachments) && !empty($attachments)) {
                return $this->response->setJSON([
                    'success' => true,
                    'attachments' => $attachments
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'attachments' => []
        ]);
    }
}