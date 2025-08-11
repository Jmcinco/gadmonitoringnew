<?php

namespace App\Controllers;
use App\Models\MfoModel;
use App\Models\PapModel;

class MfoPapController extends BaseController
{
    public function index()
    {
        $mfoModel = new MfoModel();
        $papModel = new PapModel();
        $data['mfos'] = $mfoModel->findAll();
        $data['paps'] = $papModel->findAll();
        return view('Secretariat/MfoPap', $data);
    }

    // MFO CRUD
    public function storeMfo()
    {
        $mfoModel = new MfoModel();
        $mfoModel->save([
            'mfo_code' => $this->request->getPost('mfo_code'),
            'mfo_desc' => $this->request->getPost('mfo_desc'),
        ]);
        return redirect()->to('/Secretariat/MfoPap');
    }

    public function updateMfo($id)
    {
        $mfoModel = new MfoModel();
        $mfoModel->update($id, [
            'mfo_code' => $this->request->getPost('mfo_code'),
            'mfo_desc' => $this->request->getPost('mfo_desc'),
        ]);
        return redirect()->to('/Secretariat/MfoPap');
    }

    public function deleteMfo($id)
    {
        $mfoModel = new MfoModel();
        $mfoModel->delete($id);
        return redirect()->to('/Secretariat/MfoPap');
    }

    // PAP CRUD
    public function storePap()
    {
        $papModel = new PapModel();
        $papModel->save([
            'mfo_code' => $this->request->getPost('mfo_code'),
            'mfo_desc' => $this->request->getPost('mfo_desc'),
            'pap'      => $this->request->getPost('pap'),
        ]);
        return redirect()->to('/Secretariat/MfoPap');
    }

    public function updatePap($id)
    {
        $papModel = new PapModel();
        $papModel->update($id, [
            'mfo_code' => $this->request->getPost('mfo_code'),
            'mfo_desc' => $this->request->getPost('mfo_desc'),
            'pap'      => $this->request->getPost('pap'),
        ]);
        return redirect()->to('/Secretariat/MfoPap');
    }

    public function deletePap($id)
    {
        $papModel = new PapModel();
        $papModel->delete($id);
        return redirect()->to('/Secretariat/MfoPap');
    }
}