<?php

namespace App\Controllers;
use App\Models\EmployeeModel;
use App\Models\DivisionModel;
use App\Models\PositionModel;
use App\Models\RoleModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role_id') != 4) {
            $this->session->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('/login'));
        }
        $data = [
            'first_name' => $this->session->get('first_name'),
            'last_name' => $this->session->get('last_name')
        ];
        return view('AdminDashboard', $data);
    }

    public function index()
    {

        $employeeModel = new EmployeeModel();
        $divisionModel = new DivisionModel();
        $positionModel = new PositionModel();
        $roleModel = new RoleModel();

        $data['employees'] = $employeeModel
            ->select('employees.*, divisions.division, positions.position, roles.role')
            ->join('divisions', 'divisions.div_id = employees.div_id')
            ->join('positions', 'positions.pos_id = employees.pos_id')
            ->join('roles', 'roles.role_id = employees.role_id')
            ->findAll();

        $data['divisions'] = $divisionModel->findAll();
        $data['positions'] = $positionModel->findAll();
        $data['roles'] = $roleModel->findAll();

        // NOTE: No leading slash in the view path!
        return view('Admin/EmployeesManagement', $data);
    }

    public function store()
    {
        $employeeModel = new EmployeeModel();

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'div_id'     => $this->request->getPost('div_id'),
            'pos_id'     => $this->request->getPost('pos_id'),
            'role_id'    => $this->request->getPost('role_id'),
            'gender'     => $this->request->getPost('gender'),
            'email'      => $this->request->getPost('email'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $employeeModel->save($data);
        return redirect()->to('Admin/EmployeesManagement');
    }

    public function update($id)
    {
        $employeeModel = new EmployeeModel();

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'div_id'     => $this->request->getPost('div_id'),
            'pos_id'     => $this->request->getPost('pos_id'),
            'role_id'    => $this->request->getPost('role_id'),
            'gender'     => $this->request->getPost('gender'),
            'email'      => $this->request->getPost('email'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $employeeModel->update($id, $data);
        return redirect()->to('Admin/EmployeesManagement');
    }

    public function delete($id)
    {
        $employeeModel = new EmployeeModel();
        $employeeModel->delete($id);
        return redirect()->to('Admin/EmployeesManagement');
    }
}