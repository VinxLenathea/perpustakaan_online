<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    $recentDocuments = \App\Models\DocumentModel::with('category')->latest()->take(2)->get();
    return view('welcome', compact('recentDocuments'));
});

Route::get('/collection/{category}', [App\Http\Controllers\CollectionController::class, 'index'])->name('collection');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // library management
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/store', [LibraryController::class, 'store'])->name('library.store');
    route::delete('/library/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');
    Route::get('/library/{document}/edit', [LibraryController::class, 'edit'])->name('library.edit');
    Route::put('/library/{document}', [LibraryController::class, 'update'])->name('library.update');
    // user management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');          // daftar user
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // form tambah
    Route::post('/users', [UserController::class, 'store'])->name('users.store');         // simpan user baru
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');// form edit
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // update data user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // hapus user
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

});

require __DIR__.'/auth.php';
