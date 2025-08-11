<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class FileController extends Controller
{
    public function serve($filename)
    {
        $filePath = WRITEPATH . 'uploads/' . $filename;
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null, true);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}