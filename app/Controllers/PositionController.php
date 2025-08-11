<?php

namespace App\Controllers;

use App\Models\PositionModel;
use CodeIgniter\Controller;

class PositionController extends Controller
{
    public function index()
    {
        $positionModel = new PositionModel();
        $data['positions'] = $positionModel->findAll();
        return view('Secretariat/PositionsManagement', $data);
    }

    public function store()
    {
        $positionModel = new PositionModel();
        $positionModel->save([
            'position' => $this->request->getPost('position'),
            'code' => $this->request->getPost('code'),
        ]);
        return redirect()->to('/Secretariat/PositionsManagement');
    }

    public function update($id)
    {
        $positionModel = new PositionModel();
        $positionModel->update($id, [
            'position' => $this->request->getPost('position'),
            'code' => $this->request->getPost('code'),
        ]);
        return redirect()->to('/Secretariat/PositionsManagement');
    }

    public function delete($id)
    {
        $positionModel = new PositionModel();
        $positionModel->delete($id);
        return redirect()->to('/Secretariat/PositionsManagement');
    }
}