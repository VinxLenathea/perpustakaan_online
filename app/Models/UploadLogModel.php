<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentModel;
use App\Models\User;
use App\Models\ClientModel;

class UploadLogModel extends Model
{
    protected $table = 'upload_logs';

    protected $fillable = [
        'document_id',
        'user_id',
        'client_id',
        'action',
        'status',
    ];

    public function document()
    {
        return $this->belongsTo(DocumentModel::class, 'document_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(ClientModel::class, 'client_id');
    }
}
