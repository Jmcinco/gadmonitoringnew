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

        // Get dashboard statistics
        $db = \Config\Database::connect();

        // Total GAD Plans
        $totalPlans = $db->table('plan')->countAllResults();

        // Plans by status
        $pendingPlans = $db->table('plan')->where('status', 'Pending')->countAllResults();
        $approvedPlans = $db->table('plan')->where('status', 'Approved')->countAllResults();
        $returnedPlans = $db->table('plan')->where('status', 'Returned')->countAllResults();
        $draftPlans = $db->table('plan')->where('status', 'Draft')->countAllResults();

        // Budget calculations
        $totalBudgetQuery = $db->table('budget b')
            ->select('COALESCE(SUM(b.amount), 0) as total')
            ->join('plan p', 'p.plan_id = b.plan_id', 'inner')
            ->get();
        $totalBudget = $totalBudgetQuery->getRow()->total ?? 0;

        $approvedBudgetQuery = $db->table('budget b')
            ->select('COALESCE(SUM(b.amount), 0) as total')
            ->join('plan p', 'p.plan_id = b.plan_id', 'inner')
            ->where('p.status', 'Approved')
            ->get();
        $approvedBudget = $approvedBudgetQuery->getRow()->total ?? 0;

        $pendingBudgetQuery = $db->table('budget b')
            ->select('COALESCE(SUM(b.amount), 0) as total')
            ->join('plan p', 'p.plan_id = b.plan_id', 'inner')
            ->where('p.status', 'Pending')
            ->get();
        $pendingBudget = $pendingBudgetQuery->getRow()->total ?? 0;

        $draftBudgetQuery = $db->table('budget b')
            ->select('COALESCE(SUM(b.amount), 0) as total')
            ->join('plan p', 'p.plan_id = b.plan_id', 'inner')
            ->where('p.status', 'Draft')
            ->get();
        $draftBudget = $draftBudgetQuery->getRow()->total ?? 0;

        // Recent plans (last 10)
        $recentPlans = $db->table('plan p')
            ->select('p.*, d.division, COALESCE(SUM(b.amount), 0) as total_budget')
            ->join('divisions d', 'p.authors_division = d.div_id', 'left')
            ->join('budget b', 'p.plan_id = b.plan_id', 'left')
            ->groupBy('p.plan_id, d.division')
            ->orderBy('p.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        // Accomplishments count from output table
        $accomplishments = $db->table('output')->countAllResults();

        // Accomplishments by status
        $completedAccomplishments = $db->table('output')->where('status', 'completed')->countAllResults();
        $pendingAccomplishments = $db->table('output')->where('status', 'pending')->countAllResults();
        $approvedAccomplishments = $db->table('output')->where('status', 'approved')->countAllResults();

        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name'),
            'totalPlans' => $totalPlans,
            'pendingPlans' => $pendingPlans,
            'approvedPlans' => $approvedPlans,
            'returnedPlans' => $returnedPlans,
            'draftPlans' => $draftPlans,
            'totalBudget' => $totalBudget,
            'approvedBudget' => $approvedBudget,
            'pendingBudget' => $pendingBudget,
            'draftBudget' => $draftBudget,
            'recentPlans' => $recentPlans,
            'accomplishments' => $accomplishments,
            'totalAccomplishments' => $accomplishments, // For backward compatibility
            'completedAccomplishments' => $completedAccomplishments,
            'pendingAccomplishments' => $pendingAccomplishments,
            'approvedAccomplishments' => $approvedAccomplishments
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

    // ✅ Fetch MFO and PAP data from DB
    $mfoModel = new \App\Models\MfoModel();
    $papModel = new \App\Models\PapModel();
    $mfos = $mfoModel->findAll();
    $paps = $papModel->getAllWithMfo();

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
        'divisions'  => $divisions,
        'mfos'       => $mfos,
        'paps'       => $paps
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

        try {
            // Get all GAD plans with division information and budget data
            $db = \Config\Database::connect();
            $builder = $db->table('plan p');
            $builder->select('p.*, d.division as office_name,
                             COALESCE(SUM(b.amount), 0) as budget_allocation,
                             GROUP_CONCAT(DISTINCT sf.source_name SEPARATOR ", ") as source_of_fund,
                             p.responsible_units as target_beneficiaries,
                             er.first_name as reviewed_by_name, er.last_name as reviewed_by_lastname,
                             ea.first_name as approved_by_name, ea.last_name as approved_by_lastname,
                             eret.first_name as returned_by_name, eret.last_name as returned_by_lastname');
            $builder->join('divisions d', 'p.authors_division = d.div_id', 'left');
            $builder->join('budget b', 'p.plan_id = b.plan_id', 'left');
            $builder->join('source_of_fund sf', 'b.src_id = sf.src_id', 'left');
            $builder->join('employees er', 'p.reviewed_by = er.emp_id', 'left');
            $builder->join('employees ea', 'p.approved_by = ea.emp_id', 'left');
            $builder->join('employees eret', 'p.returned_by = eret.emp_id', 'left');
            $builder->groupBy('p.plan_id, d.division, p.responsible_units, er.first_name, er.last_name, ea.first_name, ea.last_name, eret.first_name, eret.last_name');
            $builder->orderBy('p.created_at', 'DESC');

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

            // Get divisions for filter dropdown
            $divisions = $db->table('divisions')->select('division')->distinct()->get()->getResultArray();

            // Calculate statistics
            $approvedPlans = array_filter($gadPlans, fn($p) => strtolower($p['status']) === 'approved');
            $approvedPlansCount = count($approvedPlans);
            $totalBudget = array_sum(array_map(fn($p) => $p['budget_allocation'] ?? 0, $approvedPlans));
            $divisionsCount = count(array_unique(array_column($approvedPlans, 'office_name')));

            $data = [
                'gadPlans' => $gadPlans,
                'divisions' => $divisions,
                'approvedPlansCount' => $approvedPlansCount,
                'totalBudget' => $totalBudget,
                'divisionsCount' => $divisionsCount,
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name')
            ];

            return view('Focal/ConsolidatedPlan', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in consolidatedPlan: ' . $e->getMessage());

            $data = [
                'gadPlans' => [],
                'divisions' => [],
                'approvedPlansCount' => 0,
                'totalBudget' => 0,
                'divisionsCount' => 0,
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name')
            ];

            return view('Focal/ConsolidatedPlan', $data);
        }
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

        try {
            $outputModel = new \App\Models\OutputModel();

            // Get all accomplishments with details for view-only access
            $accomplishments = $outputModel->getAccomplishmentsWithDetails();

            // Filter to show only submitted accomplishments (not drafts)
            $accomplishments = array_filter($accomplishments, function($acc) {
                return in_array(strtolower($acc['status']), ['completed', 'under review', 'approved', 'returned']);
            });

            $data = [
                'accomplishments' => $accomplishments,
                'gadPlans' => $outputModel->getAvailableGadPlans() ?? [],
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name')
            ];

            return view('Focal/ReviewApproval', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in Focal reviewApproval: ' . $e->getMessage());

            $data = [
                'accomplishments' => [],
                'gadPlans' => [],
                'first_name' => $this->session->get('first_name'),
                'last_name' => $this->session->get('last_name')
            ];

            return view('Focal/ReviewApproval', $data);
        }
    }

    public function accomplishmentSubmission()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        try {
            $outputModel = new \App\Models\OutputModel();
            $db = \Config\Database::connect();

            // Calculate statistics for the accomplishments
            $totalAccomplishments = $db->table('output')->countAllResults();
            $draftAccomplishments = $db->table('output')->where('status', 'pending')->countAllResults();
            $submittedAccomplishments = $db->table('output')->where('status', 'completed')->countAllResults();
            $underReviewAccomplishments = $db->table('output')->where('status', 'under review')->countAllResults();
            $acceptedAccomplishments = $db->table('output')->where('status', 'approved')->countAllResults();
            $returnedAccomplishments = $db->table('output')->where('status', 'returned')->countAllResults();

            $statistics = [
                'Total' => $totalAccomplishments,
                'Draft' => $draftAccomplishments,
                'Submitted' => $submittedAccomplishments,
                'Under Review' => $underReviewAccomplishments,
                'Accepted' => $acceptedAccomplishments,
                'Returned' => $returnedAccomplishments
            ];

            $data = [
                'accomplishments' => $outputModel->getAccomplishmentsWithDetails() ?? [],
                'gadPlans' => $outputModel->getAvailableGadPlans() ?? [],
                'divisions' => $outputModel->getDivisions() ?? [],
                'statistics' => $statistics
            ];

            return view('Focal/AccomplishmentSubmission', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in accomplishmentSubmission: ' . $e->getMessage());

            $statistics = [
                'Total' => 0,
                'Draft' => 0,
                'Submitted' => 0,
                'Under Review' => 0,
                'Accepted' => 0,
                'Returned' => 0
            ];

            $data = [
                'accomplishments' => [],
                'gadPlans' => [],
                'divisions' => [],
                'statistics' => $statistics
            ];

            return view('Focal/AccomplishmentSubmission', $data);
        }
    }

    public function saveAccomplishment()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        $outputModel = new \App\Models\OutputModel();

        // Debug: Log all POST data
        $allPostData = $this->request->getPost();
        log_message('info', 'saveAccomplishment POST data: ' . json_encode($allPostData));

        // Map form status to database status
        $formStatus = $this->request->getPost('status');
        $dbStatus = 'pending'; // default
        if ($formStatus) {
            switch (strtolower($formStatus)) {
                case 'draft':
                case 'save as draft':
                    $dbStatus = 'pending';
                    break;
                case 'submitted':
                case 'submit for review':
                    $dbStatus = 'completed'; // This means submitted and awaiting review
                    break;
                default:
                    $dbStatus = strtolower($formStatus);
            }
        }

        $data = [
            'plan_id' => $this->request->getPost('gadActivityId'),
            'accomplishment' => $this->request->getPost('actualAccomplishment'),
            'status' => $dbStatus,
            'date_accomplished' => $this->request->getPost('dateAccomplished') ?: date('Y-m-d'),
            'remarks' => $this->request->getPost('additionalRemarks'),
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // TODO: Add submitted_at timestamp when database migration is complete
        // Set submitted_at timestamp if status is submitted (completed)
        // if ($dbStatus === 'completed') {
        //     $data['submitted_at'] = date('Y-m-d H:i:s');
        // }

        // Debug: Log the data array
        log_message('info', 'saveAccomplishment data array: ' . json_encode($data));

        // Handle file upload
        $file = $this->request->getFile('fileUpload');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $data['file'] = $newName;
            log_message('info', 'File uploaded: ' . $newName);
        }

        // Validate required fields
        if (empty($data['plan_id'])) {
            log_message('error', 'plan_id is empty: ' . var_export($data['plan_id'], true));
            return $this->response->setJSON(['success' => false, 'message' => 'GAD Activity ID is required']);
        }

        if (empty($data['accomplishment'])) {
            log_message('error', 'accomplishment is empty: ' . var_export($data['accomplishment'], true));
            return $this->response->setJSON(['success' => false, 'message' => 'Actual Accomplishment is required']);
        }

        try {
            log_message('info', 'Attempting to save accomplishment...');
            $result = $outputModel->save($data);

            if ($result) {
                log_message('info', 'Accomplishment saved successfully with ID: ' . $outputModel->getInsertID());
                return $this->response->setJSON(['success' => true, 'message' => 'Accomplishment saved successfully']);
            } else {
                $errors = $outputModel->errors();
                log_message('error', 'Failed to save accomplishment. Validation errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save accomplishment',
                    'validation' => $errors,
                    'debug_data' => $data
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in saveAccomplishment: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function updateAccomplishment()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        $outputModel = new \App\Models\OutputModel();
        $outputId = $this->request->getPost('outputId');

        // Debug: Log all POST data
        $allPostData = $this->request->getPost();
        log_message('info', 'updateAccomplishment POST data: ' . json_encode($allPostData));
        log_message('info', 'updateAccomplishment outputId: ' . $outputId);

        if (empty($outputId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Output ID is required']);
        }

        // Check if the record exists
        $existingRecord = $outputModel->find($outputId);
        if (!$existingRecord) {
            log_message('error', 'updateAccomplishment: Record not found for outputId: ' . $outputId);
            return $this->response->setJSON(['success' => false, 'message' => 'Accomplishment record not found']);
        }
        log_message('info', 'updateAccomplishment existing record: ' . json_encode($existingRecord));

        // Map form status to database status
        $formStatus = $this->request->getPost('editStatus');
        $dbStatus = 'pending';
        if ($formStatus) {
            switch (strtolower($formStatus)) {
                case 'draft':
                case 'save as draft':
                    $dbStatus = 'pending';
                    break;
                case 'submitted':
                case 'submit for review':
                    $dbStatus = 'completed'; // This means submitted and awaiting review
                    break;
                default:
                    $dbStatus = strtolower($formStatus);
            }
        }

        $data = [
            'plan_id' => $this->request->getPost('editGadActivityId'),
            'accomplishment' => $this->request->getPost('editActualAccomplishment'),
            'status' => $dbStatus,
            'date_accomplished' => $this->request->getPost('editDateAccomplished') ?: date('Y-m-d'),
            'remarks' => $this->request->getPost('editAdditionalRemarks')
        ];

        // TODO: Add submitted_at timestamp when database migration is complete
        // Set submitted_at timestamp if status is submitted (completed)
        // if ($dbStatus === 'completed') {
        //     $data['submitted_at'] = date('Y-m-d H:i:s');
        // }

        // Handle file upload
        $file = $this->request->getFile('editFileUpload');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $data['file'] = $newName;
        }

        try {
            // Log the data being sent for debugging
            log_message('info', 'updateAccomplishment data: ' . json_encode($data));

            // Temporarily disable validation to test
            $outputModel->skipValidation(true);

            if ($outputModel->update($outputId, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Accomplishment updated successfully']);
            } else {
                $errors = $outputModel->errors();
                log_message('error', 'updateAccomplishment validation errors: ' . json_encode($errors));

                // Try to get more detailed error information
                $db = \Config\Database::connect();
                $lastQuery = $db->getLastQuery();
                log_message('error', 'Last query: ' . $lastQuery);

                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update accomplishment',
                    'validation' => $errors,
                    'debug_data' => $data,
                    'output_id' => $outputId
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in updateAccomplishment: ' . $e->getMessage());
            log_message('error', 'updateAccomplishment data that caused error: ' . json_encode($data));
            return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function deleteAccomplishment($outputId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            $outputModel = new \App\Models\OutputModel();

            if ($outputModel->delete($outputId)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Accomplishment deleted successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete accomplishment']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in deleteAccomplishment: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function getAccomplishment($outputId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            $outputModel = new \App\Models\OutputModel();
            $accomplishment = $outputModel->getAccomplishmentWithDetails($outputId);

            if ($accomplishment) {
                return $this->response->setJSON(['success' => true, 'accomplishment' => $accomplishment]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Accomplishment not found']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in getAccomplishment: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function updateAccomplishmentStatus()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        $uniqueId = $this->request->getPost('outputId');
        $status = $this->request->getPost('status');

        // Map form status to database status
        $dbStatus = 'pending';
        if ($status) {
            switch (strtolower($status)) {
                case 'draft':
                    $dbStatus = 'pending';
                    break;
                case 'submitted':
                    $dbStatus = 'completed';
                    break;
                default:
                    $dbStatus = strtolower($status);
            }
        }

        try {
            $db = \Config\Database::connect();
            $builder = $db->table('output');

            // Parse the unique_id to get plan_id and timestamp
            $uniqueIdParts = explode('_', $uniqueId);
            $planId = $uniqueIdParts[0];
            $timestamp = isset($uniqueIdParts[1]) ? $uniqueIdParts[1] : null;

            if ($timestamp) {
                $builder->where('plan_id', $planId)->where('timestamp', $timestamp);
            } else {
                $builder->where('plan_id', $planId);
            }

            if ($builder->update(['status' => $dbStatus])) {
                return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in updateAccomplishmentStatus: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function getAllGadPlans()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            $outputModel = new \App\Models\OutputModel();
            $gadPlans = $outputModel->getAllGadPlans();

            return $this->response->setJSON([
                'success' => true,
                'data' => $gadPlans,
                'total' => count($gadPlans)
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in getAllGadPlans: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving GAD plans: ' . $e->getMessage()
            ]);
        }
    }

    public function getGadPlanById($planId)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            $outputModel = new \App\Models\OutputModel();
            $gadPlan = $outputModel->getGadPlanById($planId);

            if ($gadPlan) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $gadPlan
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'GAD Plan not found'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in getGadPlanById: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving GAD plan: ' . $e->getMessage()
            ]);
        }
    }

    public function getAvailableGadPlans()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
        }

        try {
            $outputModel = new \App\Models\OutputModel();
            $gadPlans = $outputModel->getAvailableGadPlans();

            return $this->response->setJSON([
                'success' => true,
                'data' => $gadPlans,
                'total' => count($gadPlans)
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in getAvailableGadPlans: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error retrieving available GAD plans: ' . $e->getMessage()
            ]);
        }
    }



    public function consolidatedAccomplishment()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }

        try {
            $outputModel = new \App\Models\OutputModel();

            // Get all accomplishments with details
            $allAccomplishments = $outputModel->getAccomplishmentsWithDetails();

            // Filter to show only approved accomplishments
            // Temporarily show all accomplishments for debugging
            $approvedAccomplishments = array_filter($allAccomplishments, function($acc) {
                return in_array(strtolower($acc['status']), ['approved', 'completed', 'under review']);
            });

            // Get unique divisions from approved accomplishments
            $divisions = [];
            foreach ($approvedAccomplishments as $accomplishment) {
                if (!empty($accomplishment['office_name'])) {
                    $divisions[$accomplishment['office_name']] = [
                        'division' => $accomplishment['office_name']
                    ];
                }
            }
            $divisions = array_values($divisions);

            // Calculate totals
            $totalBudget = 0;
            foreach ($approvedAccomplishments as $accomplishment) {
                $totalBudget += floatval($accomplishment['budget_allocation'] ?? 0);
            }

            $data = [
                'accomplishments' => $approvedAccomplishments,
                'divisions' => $divisions,
                'totalAccomplishments' => count($approvedAccomplishments),
                'totalBudget' => $totalBudget,
                'divisionsCount' => count($divisions),
                'first_name' => $this->session->get('first_name') ?? 'Admin',
                'last_name' => $this->session->get('last_name') ?? 'User'
            ];

            return view('Focal/ConsolidatedAccomplishment', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in consolidatedAccomplishment: ' . $e->getMessage());

            $data = [
                'accomplishments' => [],
                'divisions' => [],
                'totalAccomplishments' => 0,
                'totalBudget' => 0,
                'divisionsCount' => 0,
                'first_name' => $this->session->get('first_name') ?? 'Admin',
                'last_name' => $this->session->get('last_name') ?? 'User'
            ];

            return view('Focal/ConsolidatedAccomplishment', $data);
        }
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
            $planTitle = 'GAD Plan - ' . substr($oldPlan['issue_mandate'], 0, 50);

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