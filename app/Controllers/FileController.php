<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class FileController extends Controller
{
    public function serve($filename)
    {
        $filePath = WRITEPATH . 'uploads/' . $filename;

        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get file info
        $fileInfo = pathinfo($filePath);
        $extension = strtolower($fileInfo['extension'] ?? '');

        // Set appropriate content type for viewing in browser
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];

        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        // Set headers for inline viewing (not download)
        $this->response->setHeader('Content-Type', $contentType);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"');
        $this->response->setHeader('Content-Length', filesize($filePath));

        // Output file content
        return $this->response->setBody(file_get_contents($filePath));
    }

    public function download($filename)
    {
        $filePath = WRITEPATH . 'uploads/' . $filename;

        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Force download
        return $this->response->download($filePath, null, true);
    }
}