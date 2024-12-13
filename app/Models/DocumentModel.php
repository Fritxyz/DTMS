<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['document_name', 'file_name', 'uploaded_at', 'status', 'user_id'];
}
