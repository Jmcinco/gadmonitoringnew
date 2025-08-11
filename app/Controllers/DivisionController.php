<?php

namespace App\Controllers;
use App\Models\DivisionModel;
use CodeIgniter\Controller;

class DivisionController extends Controller
{
    public function index()
    {
        $divisionModel = new DivisionModel();
        $data['divisions'] = $divisionModel->findAll();
        return view('Secretariat/DivisionManagement', $data);
    }

    public function store()
    {
        $divisionModel = new DivisionModel();
        $divisionModel->save([
            'div_code' => $this->request->getPost('div_code'),
            'division' => $this->request->getPost('division'),
        ]);
        return redirect()->to('/Secretariat/DivisionManagement');
    }

    public function update($id)
    {
        $divisionModel = new DivisionModel();
        $divisionModel->update($id, [
            'div_code' => $this->request->getPost('div_code'),
            'division' => $this->request->getPost('division'),
        ]);
        return redirect()->to('/Secretariat/DivisionManagement');
    }

    public function delete($id)
    {
        $divisionModel = new DivisionModel();
        $divisionModel->delete($id);
        return redirect()->to('/Secretariat/DivisionManagement');
    }
}