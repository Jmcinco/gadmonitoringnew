<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class GadMandateController extends Controller
{
    protected $mandateModel;
    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->mandateModel = new \App\Models\GadMandateModel();
        $this->validation   = \Config\Services::validation();
        $this->session      = \Config\Services::session();
    }

    public function index()
    {
        $role = (int) $this->session->get('role_id');
        if (!$this->session->get('isLoggedIn') || !in_array($role, [1, 3], true)) {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $year = $this->request->getGet('year');
        $data['mandates'] = $this->mandateModel->getMandates($year);

        // NOTE: use the correct view filename you mentioned earlier
        return view('Secretariat/GadMandateManagement', $data);
    }

    public function getMandates()
    {
        $role = (int) $this->session->get('role_id');
        if (!$this->session->get('isLoggedIn') || !in_array($role, [1, 3], true)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        try {
            $year = $this->request->getVar('year');
            $mandates = $this->mandateModel->getMandates($year);
            return $this->response->setJSON([
                'success' => true,
                'mandates' => $mandates
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in GadMandateController/getMandates: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    public function getMandate($id)
{
    $role = (int) $this->session->get('role_id');
    if (!$this->session->get('isLoggedIn') || !in_array($role, [1, 3], true)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Unauthorized access.'
        ])->setStatusCode(403);
    }

    if (!$id || !is_numeric($id)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid mandate ID'
        ])->setStatusCode(400);
    }

    try {
        $mandate = $this->mandateModel->find($id);
        if ($mandate) {
            return $this->response->setJSON([
                'success' => true,
                'mandate' => $mandate
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mandate not found'
            ])->setStatusCode(404);
        }
    } catch (\Exception $e) {
        log_message('error', 'Error in GadMandateController/getMandate: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'An unexpected error occurred: ' . $e->getMessage()
        ])->setStatusCode(500);
    }
}

    public function save()
    {
        $role = (int) $this->session->get('role_id');
        if (!$this->session->get('isLoggedIn') || !in_array($role, [1, 3], true)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        if (!$this->validate($this->mandateModel->validationRules, $this->mandateModel->validationMessages)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validation->getErrors()
            ])->setStatusCode(400);
        }

        try {
            $data = [
                'id'          => $this->request->getPost('id'),
                'year'        => $this->request->getPost('year'),
                'description' => $this->request->getPost('description')
            ];

            if ($data['id']) {
                if (!$this->mandateModel->find($data['id'])) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Mandate not found'
                    ])->setStatusCode(404);
                }
                if ($this->mandateModel->update($data['id'], $data)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'GAD Mandate updated successfully'
                    ]);
                }
                throw new \Exception('Failed to update GAD Mandate');
            }

            if ($this->mandateModel->save($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'GAD Mandate saved successfully',
                    'id'      => $this->mandateModel->getInsertID()
                ]);
            }
            throw new \Exception('Failed to save GAD Mandate');
        } catch (\Exception $e) {
            log_message('error', 'Error in GadMandateController/save: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        $role = (int) $this->session->get('role_id');
        if (!$this->session->get('isLoggedIn') || !in_array($role, [1, 3], true)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        if (!$id || !is_numeric($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid mandate ID'
            ])->setStatusCode(400);
        }

        try {
            if (!$this->mandateModel->find($id)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Mandate not found'
                ])->setStatusCode(404);
            }

            if ($this->mandateModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'GAD Mandate deleted successfully'
                ]);
            }
            throw new \Exception('Failed to delete GAD Mandate');
        } catch (\Exception $e) {
            log_message('error', 'Error in GadMandateController/delete: ID=' . $id . ', Error=' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
