<?php

namespace App\Controllers;
use App\Models\EmployeeModel;
use App\Models\DivisionModel;
use App\Models\PositionModel;
use App\Models\RoleModel;
use App\Models\AuditTrailModel;

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

        // Validation rules
        $validationRules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'div_id'     => 'required|integer',
            'pos_id'     => 'required|integer',
            'role_id'    => 'required|integer',
            'gender'     => 'required|in_list[male,female,other]',
            'email'      => 'required|valid_email|is_unique[employees.email]',
            'password'   => 'required|min_length[8]'
        ];

        if (!$this->validate($validationRules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'div_id'     => (int)$this->request->getPost('div_id'),
            'pos_id'     => (int)$this->request->getPost('pos_id'),
            'role_id'    => (int)$this->request->getPost('role_id'),
            'gender'     => $this->request->getPost('gender'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        try {
            // Debug: Log the data being inserted
            log_message('debug', 'Attempting to insert employee data: ' . json_encode($data));

            // Use insert method which will automatically handle timestamps
            $result = $employeeModel->insert($data);

            if ($result) {
                log_message('debug', 'Employee inserted successfully with ID: ' . $result);

                // Log audit trail
                $auditModel = new AuditTrailModel();
                $auditModel->logActivity([
                    'user_id' => session()->get('user_id'), // Current logged-in user
                    'action' => 'CREATE',
                    'table_name' => 'employees',
                    'record_id' => $result,
                    'employee_name' => $data['first_name'] . ' ' . $data['last_name'],
                    'employee_email' => $data['email'],
                    'details' => 'New employee created: ' . $data['first_name'] . ' ' . $data['last_name'],
                    'new_data' => $data
                ]);

                session()->setFlashdata('success', 'Employee created successfully!');
            } else {
                $errors = $employeeModel->errors();
                log_message('error', 'Failed to insert employee. Errors: ' . json_encode($errors));
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error';
                session()->setFlashdata('error', 'Failed to create employee: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during employee insert: ' . $e->getMessage());
            session()->setFlashdata('error', 'Failed to create employee: ' . $e->getMessage());
        }

        return redirect()->to('Admin/EmployeesManagement');
    }

    public function update($id)
    {
        $employeeModel = new EmployeeModel();

        // Validation rules for update
        $validationRules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'div_id'     => 'required|integer',
            'pos_id'     => 'required|integer',
            'role_id'    => 'required|integer',
            'gender'     => 'required|in_list[male,female,other]',
            'email'      => "required|valid_email|is_unique[employees.email,emp_id,{$id}]"
        ];

        // Add password validation only if password is provided
        if ($this->request->getPost('password')) {
            $validationRules['password'] = 'min_length[8]';
        }

        if (!$this->validate($validationRules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

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

        try {
            // Get old data for audit trail
            $oldData = $employeeModel->find($id);

            $result = $employeeModel->update($id, $data);

            if ($result) {
                // Log audit trail
                $auditModel = new AuditTrailModel();
                $auditModel->logActivity([
                    'user_id' => session()->get('user_id'), // Current logged-in user
                    'action' => 'UPDATE',
                    'table_name' => 'employees',
                    'record_id' => $id,
                    'employee_name' => $data['first_name'] . ' ' . $data['last_name'],
                    'employee_email' => $data['email'],
                    'details' => 'Employee updated: ' . $data['first_name'] . ' ' . $data['last_name'],
                    'old_data' => $oldData,
                    'new_data' => $data
                ]);

                session()->setFlashdata('success', 'Employee updated successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to update employee');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Failed to update employee: ' . $e->getMessage());
        }

        return redirect()->to('Admin/EmployeesManagement');
    }

    public function delete($id)
    {
        $employeeModel = new EmployeeModel();

        try {
            // Get employee data before deletion for audit trail
            $employeeData = $employeeModel->find($id);

            if ($employeeData) {
                // Check for related records that will be affected
                $db = \Config\Database::connect();

                // Count related GAD plans
                $planCount = $db->table('plan')
                    ->where('reviewed_by', $id)
                    ->orWhere('approved_by', $id)
                    ->orWhere('returned_by', $id)
                    ->countAllResults();

                // Count audit trail records
                $auditCount = $db->table('audit_trail')
                    ->where('user_id', $id)
                    ->countAllResults();

                $result = $employeeModel->delete($id);

                if ($result) {
                    // Log audit trail
                    $auditModel = new AuditTrailModel();
                    $relatedInfo = '';
                    if ($planCount > 0) {
                        $relatedInfo .= " (Affected $planCount GAD plan review records)";
                    }
                    if ($auditCount > 0) {
                        $relatedInfo .= " (Affected $auditCount audit trail records)";
                    }

                    $auditModel->logActivity([
                        'user_id' => session()->get('user_id'), // Current logged-in user
                        'action' => 'DELETE',
                        'table_name' => 'employees',
                        'record_id' => $id,
                        'employee_name' => $employeeData['first_name'] . ' ' . $employeeData['last_name'],
                        'employee_email' => $employeeData['email'],
                        'details' => 'Employee deleted: ' . $employeeData['first_name'] . ' ' . $employeeData['last_name'] . $relatedInfo,
                        'old_data' => $employeeData
                    ]);

                    $successMessage = 'Employee deleted successfully!';
                    if ($planCount > 0 || $auditCount > 0) {
                        $successMessage .= ' Related records have been updated (reviewer references set to NULL).';
                    }
                    session()->setFlashdata('success', $successMessage);
                } else {
                    session()->setFlashdata('error', 'Failed to delete employee');
                }
            } else {
                session()->setFlashdata('error', 'Employee not found');
            }
        } catch (\Exception $e) {
            $errorMessage = 'Failed to delete employee: ' . $e->getMessage();

            // Provide more specific error messages for common issues
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                $errorMessage = 'Cannot delete employee: This employee has related records in the system. Please contact the administrator.';
            }

            session()->setFlashdata('error', $errorMessage);
        }

        return redirect()->to('Admin/EmployeesManagement');
    }
}