<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\DocumentHistoryModel;

class SharedController extends BaseController
{
    protected $documentModel;
    protected $documentHistoryModel;
    protected $db;  

    public function __construct() {
        $this->documentModel = new DocumentModel();
        $this->documentHistoryModel = new DocumentHistoryModel();
        $this->db = \Config\Database::connect();
    }

    public function trackingDocument() {
        $session = session();
        
        // Fetch all documents
        $documents = $this->documentModel
            ->select(
                'documents.*, 
                        users.first_name, 
                        users.last_name, 
                        users.username,
                        document_history.changed_status_at'
            )  
            ->join('users', 'users.id = documents.user_id') 
            ->join('document_history', 'documents.id = document_history.document_id') // Corrected the join condition// Join condition on documents.id
            ->findAll();

        // Pass the counts and documents to the view
        $data = [
            'documents' => $documents,
        ];

        if(!$session->get('is_logged_in')) {
            return redirect()->to('/');
        }
        
        if($session->get('is_logged_in') && $session->get('role') === 'researcher') {
            return redirect()->to('/researcher-dashboard');
        }

        return view('pages/document_tracker.php', $data);
    }

    public function deleteDocument($fileName) {
        $filePath = WRITEPATH . 'uploads/' . $fileName;

        if (file_exists($filePath)) {
            // Delete the file from the server
            unlink($filePath);

            $document = $this->documentModel->where('file_name', $fileName)->first();
            
            $this->documentHistoryModel->where('document_id', $document['id'])->delete();

            // Now delete the corresponding record in the database
            $this->documentModel->where('file_name', $fileName)->delete();
    
            // Redirect back with a success message
            return redirect()->to('/admin-dashboard/document-tracker')->with('success', 'Document deleted successfully.');
        } else {
            // If the file does not exist, redirect with an error message
            return redirect()->to('/admin-dashboard/document-tracker')->with('error', 'File not found.');
        }
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

    public function updateDocument() {
        helper('form');

        // Get the POST data
        $docId = $this->request->getPost('docId');
        $newStatus = $this->request->getPost('actionType');
    
        // Log the data
        log_message('debug', 'Received docId: ' . $docId);
        log_message('debug', 'Received actionType: ' . $newStatus);
    
        // Prepare data for the first table (documentModel)
        $data = ['status' => strtolower($newStatus)];

        // Update document status in the document table
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
    
        // If both updates are successful, commit the transaction and redirect with success message
        return redirect()->to('/admin-dashboard/document-tracker')->with('message', 'Document updated successfully.');
    }
}
