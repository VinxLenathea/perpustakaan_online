<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'documents';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'title',
        'author',
        'year_published',
        'category_id',
        'abstract',
        'file_url',
        'cover_image'
    ];

    /**
     * Relasi ke tabel Category
     * Satu dokumen hanya punya satu kategori
     */
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(ClientModel::class, 'client_id');
    }
}
