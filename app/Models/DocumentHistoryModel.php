<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentHistoryModel extends Model
{
    protected $table = 'document_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'document_id', 
        'user_id', 
        'uploaded_at', 
        'changed_status_at'
    ];
}
