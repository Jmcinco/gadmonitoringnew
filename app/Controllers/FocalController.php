<?php

namespace App\Controllers;

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
        return view('Focal/BudgetCrafting');
    }

    public function planReview()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        return view('Focal/PlanReview');
    }

    public function consolidatedPlan()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        return view('Focal/ConsolidatedPlan');
    }

    public function reviewApproval()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 1) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        $focalModel = new \App\Models\FocalModel();
        $data = [
            'gadPlans' => $focalModel->getGadPlans(),
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];
        return view('Focal/PlanReview', $data);
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
        return view('Focal/ConsolidatedAccomplishment');
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