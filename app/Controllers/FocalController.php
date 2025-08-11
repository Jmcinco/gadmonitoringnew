<?php

namespace App\Controllers;
use App\Models\ObjectOfExpenseModel;
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
    $divisions = $db->table('divisions')->select('division')->orderBy('division')->get()->getResult();

    $focalModel = new \App\Models\FocalModel();
    $data = [
        'gadPlans'   => $focalModel->getGadPlans(),
        'gadPlans'   => $focalModel->getGadPlansWithAmount(),
        'first_name' => $this->session->get('first_name'),
        'last_name'  => $this->session->get('last_name'),
        'divisions'  => $divisions // ✅ Add to view data
    ];

    return view('Focal/PlanPreparation', $data);
}


public function budgetCrafting()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        // Load models
        $budgetModel = new \App\Models\BudgetModel();
        $objectOfExpenseModel = new \App\Models\ObjectOfExpenseModel();
        $sourceOfFundModel = new \App\Models\SourceOfFundModel();
        $focalModel = new \App\Models\FocalModel();

        // Fetch data
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

        // Load models
        $budgetModel = new \App\Models\BudgetModel();

        // Get form data
        $data = [
            'plan_id' => $this->request->getPost('plan_id'),
            'obj_id' => $this->request->getPost('obj_id'),
            'src_id' => $this->request->getPost('src_id'),
            'particulars' => $this->request->getPost('particulars'),
            'amount' => $this->request->getPost('amount'),
            'type_of_expense' => $this->request->getPost('expenseType')
        ];

        // Validation
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

        // Attempt to insert
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

        // Load models
        $budgetModel = new \App\Models\BudgetModel();
        $act_id = $this->request->getPost('act_id');

        // Get form data
        $data = [
            'plan_id' => $this->request->getPost('plan_id'),
            'obj_id' => $this->request->getPost('obj_id'),
            'src_id' => $this->request->getPost('src_id'),
            'particulars' => $this->request->getPost('particulars'),
            'amount' => $this->request->getPost('amount'),
            'type_of_expense' => $this->request->getPost('expenseType')
        ];

        // Validation
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

        // Include act_id in validation
        $validationData = array_merge(['act_id' => $act_id], $data);

        if (!$validation->run($validationData)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validation->getErrors()
            ])->setStatusCode(400);
        }

        // Attempt to update
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

        // Load model
        $budgetModel = new \App\Models\BudgetModel();
        $act_id = $this->request->getPost('act_id');

        // Validation
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

        // Attempt to delete
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
        $data = [
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

        $focalModel = new \App\Models\FocalModel();
        $data = [
            'status' => $status,
            'remarks' => $remarks
        ];

        if ($focalModel->update($planId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status.'
            ])->setStatusCode(500);
        }
    }
}