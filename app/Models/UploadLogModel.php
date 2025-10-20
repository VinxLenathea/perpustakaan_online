<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(documentModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}
