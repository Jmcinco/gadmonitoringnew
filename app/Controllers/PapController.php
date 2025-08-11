<?php

namespace App\Controllers;

use App\Models\PapModel;
use App\Models\MfoModel;
use CodeIgniter\Controller;

class PapController extends Controller
{
    public function index()
    {
        $papModel = new PapModel();
        $mfoModel = new MfoModel();

        $data['paps'] = $papModel->getAllWithMfo();
        $data['mfos'] = $mfoModel->findAll();
        return view('Secretariat/MfoPap', $data);
    }

    public function store()
    {
        $papModel = new PapModel();
        $papModel->save([
            'mfo_id' => $this->request->getPost('mfo_id'),
            'pap'    => $this->request->getPost('pap'),
        ]);
        return redirect()->to('/Secretariat/MfoPap');
    }

    public function update($id)
    {
        $papModel = new PapModel();
        $papModel->update($id, [
            'mfo_id' => $this->request->getPost('mfo_id'),
            'pap'    => $this->request->getPost('pap'),
        ]);
        return redirect()->to('/Secretariat/MfoPap');
    }

    public function delete($id)
    {
        $papModel = new PapModel();
        $papModel->delete($id);
        return redirect()->to('/Secretariat/MfoPap');
    }
}