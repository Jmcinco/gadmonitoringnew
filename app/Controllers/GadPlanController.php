<?php

namespace App\Controllers;
use App\Models\BudgetModel;
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
        // Load the Form Helper in the constructor
        helper('form');
    }

    public function index()
    {
        // Ensure the Form Helper is available
        helper('form');

        $data['gadPlans']  = $this->model->getGadPlansWithAmount();
        $data['mandates'] = $this->mandateModel->findAll();
        $data['divisions'] = $this->getDivisions();
        return view('Focal/PlanPreparation', $data);
    }

    protected function getDivisions()
    {
        $db = \Config\Database::connect();
        return $db->table('divisions')->get()->getResult();
    }

    public function save($id = null)
    {
        // auth
        if (! $this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            return $this->response
                        ->setStatusCode(403)
                        ->setJSON(['success'=>false,'message'=>'Unauthorized access.']);
        }

        $post      = $this->request->getPost();
        $isDraft   = (isset($post['is_draft']) && $post['is_draft']==='1');
        $planId    = $post['planId'] ?? $id;

        // validation rules
        $rules = $isDraft ? [] : [
            'issue_mandate'    => 'required|min_length[10]',
            'cause'            => 'required|min_length[10]',
            'gad_objective.*'  => 'permit_empty|min_length[10]',
            'activity'         => 'required|min_length[10]',
            'indicator_text' => 'required',
            'target_text'    => 'required',
            'startDate'        => 'required|valid_date',
            'endDate'          => 'required|valid_date',
            'responsibleUnits' => 'required',
            'status'           => 'required|in_list[Pending,In Progress,Completed]',
            'budgetAmount'     => 'required|numeric|greater_than[0]',
            'hgdgScore'        => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'fileAttachments.*'=> 'permit_empty|uploaded[fileAttachments]|max_size[fileAttachments,10240]|ext_in[fileAttachments,pdf,doc,docx,jpg,png]',
        ];
        
        $rawIndicators = $this->request->getPost('indicators') ?? [];
        if (! is_array($rawIndicators)) {
            $rawIndicators = [$rawIndicators];
        }
        $rawTargets = $this->request->getPost('targets') ?? [];
        if (! is_array($rawTargets)) {
            $rawTargets = [$rawTargets];
        }

        if (! $isDraft && ! $this->validate($rules)) {
            return $this->response
                        ->setStatusCode(400)
                        ->setJSON([
                            'success'=>false,
                            'message'=>'Validation failed',
                            'errors'=> $this->validator->getErrors()
                        ]);
        }

        // parse objectives
        $objectives = $this->request->getPost('gad_objective') ?? [];
        if (! is_array($objectives)) {
            $objectives = [$objectives];
        }
        $objectives = array_filter($objectives, fn($v)=> is_string($v) && strlen(trim($v))>=10);

        if (! $isDraft && empty($objectives)) {
            return $this->response
                        ->setStatusCode(400)
                        ->setJSON([
                            'success'=>false,
                            'message'=>'Validation failed',
                            'errors'=>['gad_objective'=>'At least one valid GAD objective is required.']
                        ]);
        }

        // date check
        if (! $isDraft) {
            $start = strtotime($post['startDate']);
            $end   = strtotime($post['endDate']);
            if ($end <= $start) {
                return $this->response
                            ->setStatusCode(400)
                            ->setJSON([
                                'success'=>false,
                                'message'=>'Validation failed',
                                'errors'=>['endDate'=>'End date must be after start date.']
                            ]);
            }
        }

        // parse MFO/PAP
        $mfoPapData = json_decode($post['mfoPapData'] ?? '[]', true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $mfoPapData = [];
        }

        // responsible units
        $units = $this->request->getPost('responsibleUnits') ?? [];
        if (! is_array($units)) {
            $units = [$units];
        }

        // handle file uploads
        $attachments = [];
        foreach ($this->request->getFiles()['fileAttachments'] ?? [] as $file) {
            if ($file->isValid() && ! $file->hasMoved()) {
                $name = $file->getRandomName();
                $file->move(WRITEPATH.'uploads', $name);
                $attachments[] = 'Uploads/'.$name;
            }
        }

        // payload
        $saveData = [
            'plan_id'          => $planId,                // needed by Model->save()
            'issue_mandate'    => $post['issue_mandate'],
            'cause'            => $post['cause'],
            'gad_objective'    => json_encode($objectives),
            'activity'         => $post['activity'],
              'indicator_text' => $post['indicator_text'],
              'target_text'    => $post['target_text'],
            'startDate'        => $post['startDate'],
            'endDate'          => $post['endDate'],
            'authors_division' => json_encode($units),
            'status'           => $isDraft ? 'Draft' : $post['status'],
            'budget'           => $post['budgetAmount'],
            'hgdg_score'       => $post['hgdgScore'],
            'file_attachments' => json_encode($attachments),
            'mfoPapData'       => json_encode($mfoPapData),
            'is_draft'         => $isDraft ? 1 : 0,
        ];

        // skip built-in model validation since we've done ours
        $this->model->skipValidation(true);

        // save() will INSERT or UPDATE based on presence of plan_id
        $this->model->save($saveData);
        $insertId = $this->model->getInsertID() ?: $planId;

        return $this->response
                    ->setJSON([
                        'success'         => true,
                        'message'         => $isDraft
                                               ? 'GAD Plan saved as draft'
                                               : 'GAD Plan saved successfully',
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
                  ->select('plan.*, COALESCE(SUM(b.amount),0) AS total_budget')
                  ->join('budget b', 'b.plan_id = plan.plan_id', 'left')
                  ->where('plan.plan_id', $id)
                  ->groupBy('plan.plan_id');
    $plan = $builder->get()->getRowArray();

    if (! $plan) {
        return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['success'=>false,'message'=>'GAD Plan not found']);
    }

    // decode JSON fields
    $plan['gad_objective']    = json_decode($plan['gad_objective'], true)    ?: [];
    $plan['authors_division'] = json_decode($plan['authors_division'], true) ?: [];
    $plan['file_attachments'] = json_decode($plan['file_attachments'], true) ?: [];
    $plan['mfoPapData']       = json_decode($plan['mfoPapData'], true)       ?: [];

    // leave indicators/targets as strings
    $plan['indicators'] = json_decode($plan['indicator_text'], true) ?: [];
    $plan['targets']    = json_decode($plan['target_text'],    true) ?: [];


    return $this->response
                ->setJSON(['success'=>true,'plan'=>$plan]);
}


    public function deleteGadPlan($id)
{
    // authorization
    if (! $this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
        return $this->response
                    ->setStatusCode(403)
                    ->setJSON(['success' => false, 'message' => 'Unauthorized access.']);
    }

    // ensure plan exists
    $plan = $this->model->find($id);
    if (! $plan) {
        return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['success' => false, 'message' => 'GAD Plan not found']);
    }

    // 1) delete all budgets for this plan
    $budgetModel = new BudgetModel();
    $budgetModel->where('plan_id', $id)->delete();

    // 2) delete any uploaded attachments
    foreach (json_decode($plan['file_attachments'], true) ?: [] as $file) {
        $path = WRITEPATH . $file;
        if (is_file($path)) {
            unlink($path);
        }
    }

    // 3) delete the plan itself
    $this->model->delete($id);

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
            if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ])->setStatusCode(403);
            }

            $year = $this->request->getPost('year');
            $builder = $this->mandateModel->builder();
            if ($year) {
                $builder->where('year', $year);
            }
            $mandates = $builder->get()->getResultArray();

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