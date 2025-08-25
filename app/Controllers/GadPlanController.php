<?php

namespace App\Controllers;
use App\Models\BudgetModel;
use App\Models\AuditTrailModel;
use CodeIgniter\Controller;

class GadPlanController extends Controller
{
    protected $validation;
    protected $session;
    protected $model;
    protected $mandateModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->model = new \App\Models\FocalModel();
        $this->mandateModel = new \App\Models\GadMandateModel();
        helper('form');
    }

    public function index()
    {
        helper('form');
        $data['gadPlans']  = $this->model->getGadPlansWithAmount();
        $data['mandates'] = $this->mandateModel->findAll();
        $data['divisions'] = $this->getDivisions();
        $data['currentDivision'] = session()->get('division');

        // Create division lookup array for efficiency
        $db = \Config\Database::connect();
        $divisions = $db->table('divisions')->get()->getResultArray();
        $divisionLookup = [];
        foreach ($divisions as $div) {
            $divisionLookup[$div['div_id']] = $div['division'];
        }

        foreach ($data['gadPlans'] as &$plan) {
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
        unset($plan);

        return view('Focal/PlanPreparation', $data);
    }

    protected function getDivisions()
    {
        $db = \Config\Database::connect();
        return $db->table('divisions')->get()->getResult();
    }

    public function save($id = null)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON(['success' => false, 'message' => 'Unauthorized access.']);
        }

        $post = $this->request->getPost();
        $isDraft = isset($post['is_draft']) && $post['is_draft'] === '1';
        $planId = $post['planId'] ?? $id;

        $rules = $isDraft ? [] : [
            'issue_mandate'    => 'required|min_length[10]',
            'cause'            => 'required|min_length[10]',
            'gad_objective.*'  => 'permit_empty|min_length[10]',
            'activity'         => 'required|min_length[10]',
            'indicator_text'   => 'required',
            'target_text'      => 'required',
            'startDate'        => 'required|valid_date',
            'endDate'          => 'required|valid_date',
            'responsibleUnits' => 'required',
            'status'           => 'required|in_list[Pending,In Progress,Completed]',
            'budgetAmount'     => 'required|numeric|greater_than[0]',
            'hgdgScore'        => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'fileAttachments.*'=> 'permit_empty|uploaded[fileAttachments]|max_size[fileAttachments,10240]|ext_in[fileAttachments,pdf,doc,docx,jpg,png]',
        ];

        if (!$isDraft && !$this->validate($rules)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $this->validator->getErrors()
                ]);
        }

        $objectives = $this->request->getPost('gad_objective') ?? [];
        if (!is_array($objectives)) {
            $objectives = [$objectives];
        }
        $objectives = array_filter($objectives, fn($v) => is_string($v) && strlen(trim($v)) >= 10);

        if (!$isDraft && empty($objectives)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => ['gad_objective' => 'At least one valid GAD objective is required.']
                ]);
        }

        if (!$isDraft) {
            $start = strtotime($post['startDate']);
            $end = strtotime($post['endDate']);
            if ($end <= $start) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors'  => ['endDate' => 'End date must be after start date.']
                    ]);
            }
        }

        $units = $this->request->getPost('responsibleUnits') ?? [];
        if (!is_array($units)) {
            $units = [$units];
        }
        $units = array_filter($units);

        $authors_division = $this->session->get('div_id');

        // If div_id is not in session, try to get it from the user's data
        if (!$authors_division) {
            $db = \Config\Database::connect();
            $user = $db->table('employees')
                       ->where('emp_id', $this->session->get('user_id'))
                       ->get()
                       ->getRowArray();
            if ($user) {
                $authors_division = $user['div_id'];
                // Update session with the div_id for future use
                $this->session->set('div_id', $authors_division);
            }
        }

        $attachments = [];
        foreach ($this->request->getFiles()['fileAttachments'] ?? [] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $name = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $name);
                $attachments[] = 'Uploads/' . $name;
            }
        }

        $mfoPapData = $post['mfoPapData'] ?? json_encode([]);

        // Debug: Log the MFO/PAP data being saved
        log_message('info', 'Saving GAD Plan - MFO/PAP Data: ' . $mfoPapData);
        log_message('info', 'Saving GAD Plan - Raw POST data: ' . json_encode($post));

        $saveData = [
            'plan_id'             => $planId,
            'issue_mandate'       => $post['issue_mandate'],
            'cause'               => $post['cause'],
            'gad_objective'       => json_encode($objectives),
            'activity'            => $post['activity'],
            'indicator_text'      => $post['indicator_text'],
            'target_text'         => $post['target_text'],
            'startDate'           => $post['startDate'],
            'endDate'             => $post['endDate'],
            'responsible_units'   => json_encode($units),
            'authors_division'    => $authors_division,
            'status'              => $isDraft ? 'Draft' : $post['status'],
            'budget'              => $post['budgetAmount'],
            'hgdg_score'          => $post['hgdgScore'],
            'file_attachments'    => json_encode($attachments),
            'mfoPapData'          => $mfoPapData,
        ];

        $this->model->skipValidation(true);
        $result = $this->model->save($saveData);
        $insertId = $this->model->getInsertID() ?: $planId;

        if ($result) {
            // Log audit trail for GAD Plan activity
            $auditModel = new AuditTrailModel();
            $action = $planId ? 'UPDATE' : 'CREATE';
            $planTitle = 'GAD Plan - ' . substr($post['issue_mandate'], 0, 50);

            // Get old data for updates
            $oldData = null;
            if ($planId) {
                $oldData = $this->model->find($planId);
            }

            $auditModel->logActivity([
                'user_id' => $this->session->get('user_id'),
                'action' => $action,
                'table_name' => 'plan',
                'record_id' => $insertId,
                'employee_name' => $planTitle,
                'employee_email' => $this->session->get('email'),
                'details' => ($isDraft ? 'GAD Plan saved as draft: ' : 'GAD Plan ' . strtolower($action) . 'd: ') . $planTitle,
                'old_data' => $oldData,
                'new_data' => $saveData
            ]);
        }

        return $this->response
            ->setJSON([
                'success'         => true,
                'message'         => $isDraft ? 'GAD Plan saved as draft' : 'GAD Plan saved successfully',
                'planId'          => $insertId,
                'fileAttachments' => $attachments,
            ]);
    }

    public function getGadPlan($id)
    {
        if (! $this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response
                        ->setStatusCode(403)
                        ->setJSON(['success'=>false,'message'=>'Unauthorized access.']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('plan')
                      ->select('plan.*, d.division, COALESCE(SUM(b.amount),0) AS total_budget')
                      ->join('budget b', 'b.plan_id = plan.plan_id', 'left')
                      ->join('divisions d', 'plan.authors_division = d.div_id', 'left')
                      ->where('plan.plan_id', $id)
                      ->groupBy('plan.plan_id, d.division');
        $plan = $builder->get()->getRowArray();

        if (! $plan) {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON(['success'=>false,'message'=>'GAD Plan not found']);
        }

        $plan['gad_objective']    = json_decode($plan['gad_objective'], true)    ?: [];
        $plan['file_attachments'] = json_decode($plan['file_attachments'], true) ?: [];
        $plan['mfoPapData']       = json_decode($plan['mfoPapData'], true)       ?: [];
        $plan['indicators'] = json_decode($plan['indicator_text'], true) ?: [];
        $plan['targets']    = json_decode($plan['target_text'],    true) ?: [];

        // Debug: Log the MFO/PAP data being retrieved
        log_message('info', 'Retrieving GAD Plan ID: ' . $id);
        log_message('info', 'Raw mfoPapData from DB: ' . ($plan['mfoPapData'] ? json_encode($plan['mfoPapData']) : 'null'));
        log_message('info', 'Decoded mfoPapData: ' . json_encode($plan['mfoPapData']));

        return $this->response
                    ->setJSON(['success'=>true,'plan'=>$plan]);
    }

    public function deleteGadPlan($id)
    {
        if (! $this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response
                        ->setStatusCode(403)
                        ->setJSON(['success' => false, 'message' => 'Unauthorized access.']);
        }

        $plan = $this->model->find($id);
        if (! $plan) {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON(['success' => false, 'message' => 'GAD Plan not found']);
        }

        $budgetModel = new BudgetModel();
        $budgetModel->where('plan_id', $id)->delete();

        foreach (json_decode($plan['file_attachments'], true) ?: [] as $file) {
            $path = WRITEPATH . $file;
            if (is_file($path)) {
                unlink($path);
            }
        }

        $result = $this->model->delete($id);

        if ($result) {
            // Log audit trail for GAD Plan deletion
            $auditModel = new AuditTrailModel();
            $planTitle = 'GAD Plan - ' . substr($plan['issue_mandate'], 0, 50);

            $auditModel->logActivity([
                'user_id' => $this->session->get('user_id'),
                'action' => 'DELETE',
                'table_name' => 'plan',
                'record_id' => $id,
                'employee_name' => $planTitle,
                'employee_email' => $this->session->get('email'),
                'details' => 'GAD Plan deleted: ' . $planTitle,
                'old_data' => $plan
            ]);
        }

        return $this->response
                    ->setJSON([
                      'success' => true,
                      'message' => 'GAD Plan and its budget items deleted successfully'
                    ]);
    }

    public function saveMandate()
    {
        try {
            if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ])->setStatusCode(403);
            }

            $validationRules = [
                'year' => 'required|numeric|exact_length[4]',
                'description' => 'required|min_length[10]'
            ];

            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->validation->getErrors()
                ])->setStatusCode(400);
            }

            $data = [
                'id' => $this->request->getPost('id'),
                'year' => $this->request->getPost('year'),
                'description' => $this->request->getPost('description')
            ];

            if ($this->mandateModel->save($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'GAD Mandate saved successfully'
                ]);
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save mandate']);
        } catch (\Exception $e) {
            log_message('error', 'Error in GadPlanController/saveMandate: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }







    public function getMandates()
    {
        try {
            log_message('info', 'getMandates called - Session data: ' . json_encode([
                'isLoggedIn' => $this->session->get('isLoggedIn'),
                'role_id' => $this->session->get('role_id')
            ]));

            if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
                log_message('warning', 'Unauthorized access to getMandates');
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ])->setStatusCode(403);
            }

            $year = $this->request->getPost('year');
            log_message('info', 'getMandates - Year filter: ' . ($year ?: 'none'));

            $builder = $this->mandateModel->builder();
            if ($year) {
                $builder->where('year', $year);
            }
            $mandates = $builder->get()->getResultArray();

            log_message('info', 'getMandates - Found ' . count($mandates) . ' mandates');

            // If no mandates found, let's check if table exists and has any data
            if (empty($mandates)) {
                $totalCount = $this->mandateModel->countAll();
                log_message('info', 'Total mandates in database: ' . $totalCount);

                // If no mandates exist at all, create some sample data
                if ($totalCount === 0) {
                    $sampleMandates = [
                        ['year' => 2024, 'description' => 'Republic Act No. 9710 - Magna Carta of Women'],
                        ['year' => 2024, 'description' => 'Republic Act No. 11313 - Safe Spaces Act (Bawal Bastos Law)'],
                        ['year' => 2024, 'description' => 'Executive Order No. 273 - Philippine Plan for Gender-Responsive Development']
                    ];

                    foreach ($sampleMandates as $mandate) {
                        $this->mandateModel->insert($mandate);
                    }

                    // Re-fetch mandates
                    $builder = $this->mandateModel->builder();
                    if ($year) {
                        $builder->where('year', $year);
                    }
                    $mandates = $builder->get()->getResultArray();
                    log_message('info', 'Created sample mandates, now found: ' . count($mandates));
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'mandates' => $mandates
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in GadPlanController/getMandates: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }
}
