<?php

use App\Http\Controllers\DocumentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API untuk upload dokumen
Route::post('/documents', [DocumentApiController::class, 'upload']);
