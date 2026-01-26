<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryModel;
use App\Models\ClientModel;
use App\Models\UploadLogModel;

class DocumentModel extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'title',
        'author',
        'year_published',
        'category_id',
        'abstract',
        'file_url',
        'cover_image',
        'kampus',
        'prodi',
        'views',
        'client_id',
        'status'
    ];

    // ✅ RELASI KE CATEGORY
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    // ✅ RELASI KE CLIENT
    public function client()
    {
        return $this->belongsTo(ClientModel::class, 'client_id');
    }

    // ✅ RELASI KE UPLOAD LOGS (INI YANG WAJIB ADA)
    public function uploadLogs()
    {
        return $this->hasMany(UploadLogModel::class, 'document_id', 'id');
    }
}
