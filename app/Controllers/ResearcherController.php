<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentHistoryModel;
use App\Models\DocumentModel;
use CodeIgniter\HTTP\ResponseInterface;

class ResearcherController extends BaseController
{

    protected $documentModel;
    protected $documentHistoryModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->documentHistoryModel = new DocumentHistoryModel();
    }

    public function index()
    {
        $session = session();
        
        // Fetch all documents
        // $documents = $this->documentModel
        //     ->where('user_id', $session->get('id'))
        //     ->findAll();

        $documents = $this->documentModel
            ->select(
                'documents.*, 
                        users.first_name, 
                        users.last_name, 
                        users.username,
                        document_history.changed_status_at'
            ) 
            ->where('users.id', $session->get('id'))
            ->join('users', 'users.id = documents.user_id') 
            ->join('document_history', 'documents.id = document_history.document_id') // Corrected the join condition
            ->findAll();
    
        // Count the number of documents (if you just want the total count)
        $documentCount = count($documents);
    
        // You can also count specific statuses if needed (e.g. "Pending Review", "Approved", etc.)
        $pendingCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'pending'));
        $approvedCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'approved'));
        $rejectedCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'rejected'));
    
        // Pass the counts and documents to the view
        $data = [
            'documents' => $documents,
            'documentCount' => $documentCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'userInfo' => $session->get()
        ];

        if(!$session->get('is_logged_in')) {
            return redirect()->to('/');
        }

        if($session->get('role') === 'admin') {
            return redirect()->to('/admin-dashboard');
        }
    
        return view('Dashboard/research', $data);
    }
    

    public function tracking()
    {
        return view('pages/getdocumentTrack');
    }

    public function uploadDocument()
    {
        $file = $this->request->getFile('documentFile');

        $session = session();

        if($file->isValid() && !$file->hasMoved())
        {
            $extension = $file->getExtension();

            if (!in_array($extension, ['pdf', 'docx'])) {
                return redirect()->to('/researcher-dashboard')->with('error', 'Only PDF and DOCX files are allowed.');
            }

            $file_name = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/', $file_name);

            $this->documentModel->save([
                'document_name' => $this->request->getPost('documentTitle'),
                'file_name' => $file_name,
                'user_id' => $session->get('id'),
            ]);

            $document = $this->documentModel->where('file_name', $file_name)->first();

            $this->documentHistoryModel->save([
                'document_id' => $document['id'],
                'user_id' => $session->get('id'),
                'uploaded_at' => $document['uploaded_at'],
            ]);
           
            return redirect()
                ->to('/researcher-dashboard')
                ->with('success', 'File uploaded successfully.');
        }

        return redirect()->to('/researcher-dashboard')->with('error', 'Failed to upload document');
    }

    public function downloadDocument($fileName)
    {
        $filePath = WRITEPATH . 'uploads/' . $fileName;

        if(file_exists($filePath)) {
            return $this->response->download($filePath, null);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File not found');  
        }
    }

    public function deleteDocument($fileName) 
    {
        $filePath = WRITEPATH . 'uploads/' . $fileName;

        if (file_exists($filePath)) {
            // Delete the file from the server
            unlink($filePath);

            $document = $this->documentModel->where('file_name', $fileName)->first();
            
            $this->documentHistoryModel->where('document_id', $document['id'])->delete();

            // Now delete the corresponding record in the database
            $this->documentModel->where('file_name', $fileName)->delete();
    
            // Redirect back with a success message
            return redirect()->to('/researcher-dashboard')->with('success', 'Document deleted successfully.');
        } else {
            // If the file does not exist, redirect with an error message
            return redirect()->to('/researcher-dashboard')->with('error', 'File not found.');
        }
    }
}