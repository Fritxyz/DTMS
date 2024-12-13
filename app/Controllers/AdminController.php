<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentHistoryModel;
use App\Models\DocumentModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $documentModel;
    protected $documentHistoryModel;

    public function __construct() {
        $this->documentModel = new DocumentModel();
        $this->documentHistoryModel = new DocumentHistoryModel();
    }

    public function index()
    {
        $session = session();
        
        // Fetch all documents
        $documents = $this->documentModel
            ->select('documents.*, users.first_name, users.last_name, users.username')  // Select all fields from both tables
            ->join('users', 'users.id = documents.user_id')  // Join condition on user_id
            ->findAll();

        $pendingDocuments = array_filter($documents, fn($doc) => $doc['status'] === 'pending');
    
        // Count the number of documents (if you just want the total count)
        $documentCount = count($documents);
    
        // You can also count specific statuses if needed (e.g. "Pending Review", "Approved", etc.)
        $pendingCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'pending'));
        $approvedCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'approved'));
        $rejectedCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'rejected'));
    
        $chartData = [
            'pending' => $pendingCount,
            'approved' => $approvedCount,
            'rejected' => $rejectedCount,
        ];

        // Pass the counts and documents to the view
        $data = [
            'documents' => $documents,
            'pendingDocuments' => $pendingDocuments,
            'documentCount' => $documentCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'chartData' => $chartData,
        ];

        if(!$session->get('is_logged_in')) {
            return redirect()->to('/');
        }
        
        if($session->get('is_logged_in') && $session->get('role') === 'researcher') {
            return redirect()->to('/researcher-dashboard');
        }

        return view('Dashboard/admin', $data);
    }

    public function updateDocument() {

        helper('form');

        $docId = $this->request->getPost('docId');
        $newStatus = $this->request->getPost('actionType');

        log_message('debug', 'Received docId: ' . $docId);
        log_message('debug', 'Received actionType: ' . $newStatus);

        $data = ['status' => strtolower($newStatus)];

        $updated = $this->documentModel->update($docId, $data);
    
        if ($updated) {
            // Prepare data for the second table (documentHistoryModel)
            $historyData = [
                'changed_status_at' => date('Y-m-d H:i:s'),  // You can use the current timestamp
            ];

            // Update the document history table
            $this->documentHistoryModel->where('document_id', $docId)
                                       ->update(null, $historyData); 
        }

        return redirect()->to('/admin-dashboard')->with('message', 'Document updated successfully.');
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

    // public function updateDocument() {
    //     $docId = $this->request->getPost('docId');
    //     $newStatus = $this->request->getPost('actionType');
    
    //     $data = ['status' => strtolower($newStatus)];
    
    //     if ($this->documentModel->update($docId, $data)) {
    //         $session = session();
    //         $documents = $this->documentModel
    //             ->select('documents.*, users.*')
    //             ->join('users', 'users.id = documents.user_id')
    //             ->findAll(); // Fetch all documents again
    
    //         $pendingDocuments = array_filter($documents, fn($doc) => $doc['status'] === 'pending');
        
    //         $documentCount = count($documents);
    //         $pendingCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'pending'));
    //         $approvedCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'approved'));
    //         $rejectedCount = count(array_filter($documents, fn($doc) => $doc['status'] === 'rejected'));
    
    //         $data = [
    //             'documents' => $documents,
    //             'pendingDocuments' => $pendingDocuments,
    //             'documentCount' => $documentCount,
    //             'pendingCount' => $pendingCount,
    //             'approvedCount' => $approvedCount,
    //             'rejectedCount' => $rejectedCount,
    //         ];
    
    //         return redirect()->to('/admin-dashboard')->with('message', 'Document updated successfully.')->with('data', $data);
    //     }
    
    //     return redirect()->to('/admin-dashboard')->with('error', 'Failed to update the document.');
    // }

    
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
            return redirect()->to('/admin-dashboard')->with('success', 'Document deleted successfully.');
        } else {
            // If the file does not exist, redirect with an error message
            return redirect()->to('/admin-dashboard')->with('error', 'File not found.');
        }
    }
}