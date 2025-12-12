<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ClientModel extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'api_token',
    ];

    protected static function booted()
    {
        static::creating(function ($client) {
            if (empty($client->api_token)) {
                $client->api_token = Str::random(60);
            }
        });
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\documentModel::class, 'client_id');
    }

    public function uploadLogs()
    {
        return $this->hasMany(\App\Models\UploadLogModel::class, 'client_id');
    }
}
