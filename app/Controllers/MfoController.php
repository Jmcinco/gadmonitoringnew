<?php

namespace App\Controllers;
use App\Models\MfoModel;

class MfoController extends BaseController
{
    public function index()
    {
        $mfoModel = new MfoModel();
        $data['mfos'] = $mfoModel->findAll();
        return view('Secretariat/Mfo', $data);
    }

public function store()
{
    $mfoModel = new MfoModel();
    $mfoModel->save([
        'mfo_code' => $this->request->getPost('mfo_code'),
        'mfo'      => $this->request->getPost('mfo'), // <-- use mfo
    ]);
    return redirect()->to('/Secretariat/MfoPap');
}

public function update($id)
{
    $mfoModel = new MfoModel();
    $mfoModel->update($id, [
        'mfo_code' => $this->request->getPost('mfo_code'),
        'mfo'      => $this->request->getPost('mfo'), // <-- use mfo
    ]);
    return redirect()->to('/Secretariat/MfoPap');
}

    public function delete($id)
    {
        $mfoModel = new MfoModel();
        $mfoModel->delete($id);
        return redirect()->to('/Secretariat/MfoPap');
    }
}