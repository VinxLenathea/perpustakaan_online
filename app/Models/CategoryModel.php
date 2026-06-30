<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['category_name', 'category_type'];

    public function documents()
    {
        return $this->hasMany(DocumentModel::class, 'category_id', 'id');
    }
}
