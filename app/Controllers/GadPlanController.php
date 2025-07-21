<?php

namespace App\Controllers;

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
    }

    public function index()
    {
        $data['gadPlans'] = $this->model->findAll();
        $data['mandates'] = $this->mandateModel->findAll();
        return view('Focal/PlanPreparation', $data); // Updated path to match view
    }

    public function save($id = null)
    {
        try {
            // Check if user is authorized
            if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ])->setStatusCode(403);
            }

            // Define validation rules
            $validationRules = [
                'issue_mandate' => 'required|min_length[10]',
                'cause' => 'required|min_length[10]',
                'gad_objective' => 'required|min_length[10]',
                'activity' => 'required|min_length[10]',
                'indicators' => 'required|min_length[10]',
                'startDate' => 'required|valid_date',
                'endDate' => 'required|valid_date',
                'responsibleUnit' => 'required',
                'budgetAmount' => 'required|numeric|greater_than[0]',
                'mfoPapType_0' => 'permit_empty|in_list[MFO,MFA]',
                'mfoPapStatement_0' => 'permit_empty|min_length[5]',
                'mfoPapType_1' => 'permit_empty|in_list[MFO,MFA]',
                'mfoPapStatement_1' => 'permit_empty|min_length[5]',
                'mfoPapType_2' => 'permit_empty|in_list[MFO,MFA]',
                'mfoPapStatement_2' => 'permit_empty|min_length[5]',
            ];

            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->validation->getErrors()
                ])->setStatusCode(400);
            }

            // Custom date validation
            $startDate = strtotime($this->request->getPost('startDate'));
            $endDate = strtotime($this->request->getPost('endDate'));
            if ($endDate <= $startDate) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => ['endDate' => 'End date must be after start date.']
                ])->setStatusCode(400);
            }

            // Handle multiple causes and objectives
            $causes = $this->request->getPost('cause');
            $objectives = $this->request->getPost('gad_objective');
            $mfoPapData = $this->request->getPost('mfoPapData');

            if (empty($mfoPapData)) {
                $mfoPapData = [];
            } else {
                $mfoPapData = json_decode($mfoPapData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => ['mfoPapData' => 'Invalid MFO/PAP data format.']
                    ])->setStatusCode(400);
                }
            }

            // Prepare data for saving
            $data = [
                'issue_mandate' => $this->request->getPost('issue_mandate'),
                'cause' => is_array($causes) ? implode('; ', $causes) : $causes,
                'gad_objective' => is_array($objectives) ? implode('; ', $objectives) : $objectives,
                'activity' => $this->request->getPost('activity'),
                'indicators' => $this->request->getPost('indicators'),
                'startDate' => $this->request->getPost('startDate'),
                'endDate' => $this->request->getPost('endDate'),
                'authors_division' => $this->request->getPost('responsibleUnit'),
                'budget' => $this->request->getPost('budgetAmount'),
                'mfoPapData' => json_encode($mfoPapData),
            ];

            // Check for planId in POST data as a fallback
            $planId = $this->request->getPost('planId') ?? $id;

            if ($planId) {
                // Update existing plan
                if (!$this->model->find($planId)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'GAD Plan not found'
                    ])->setStatusCode(404);
                }
                if ($this->model->update($planId, $data)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'GAD Plan updated successfully',
                        'planId' => $planId
                    ]);
                } else {
                    throw new \Exception('Failed to update GAD Plan in database');
                }
            } else {
                // Create new plan
                if ($this->model->save($data)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'GAD Plan saved successfully',
                        'planId' => $this->model->getInsertID()
                    ]);
                } else {
                    throw new \Exception('Failed to save GAD Plan to database');
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in GadPlanController/save: ID=' . ($planId ?? 'new') . ', Error=' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getGadPlan($id)
    {
        try {
            if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ])->setStatusCode(403);
            }

            $plan = $this->model->find($id);
            if (!$plan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'GAD Plan not found'
                ])->setStatusCode(404);
            }

            return $this->response->setJSON([
                'success' => true,
                'plan' => [
                    'issue_mandate' => $plan['issue_mandate'],
                    'cause' => $plan['cause'],
                    'gad_objective' => $plan['gad_objective'],
                    'activity' => $plan['activity'],
                    'indicators' => $plan['indicators'],
                    'startDate' => $plan['startDate'],
                    'endDate' => $plan['endDate'],
                    'responsibleUnit' => $plan['authors_division'],
                    'budgetAmount' => $plan['budget'],
                    'mfoPapData' => $plan['mfoPapData'] ? json_decode($plan['mfoPapData'], true) : []
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in GadPlanController/getGadPlan: ID=' . $id . ', Error=' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteGadPlan($id)
    {
        try {
            if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ])->setStatusCode(403);
            }

            if (!$id || !is_numeric($id)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid GAD Plan ID'
                ])->setStatusCode(400);
            }

            $plan = $this->model->find($id);
            if (!$plan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'GAD Plan not found'
                ])->setStatusCode(404);
            }

            if ($this->model->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'GAD Plan deleted successfully'
                ]);
            } else {
                throw new \Exception('Failed to delete GAD plan from database');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in GadPlanController/deleteGadPlan: ID=' . $id . ', Error=' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
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
                return $this->response->setJSON(['success' => true]);
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
}