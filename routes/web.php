<?php

use App\Http\Controllers\CollectionAllController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeControllerController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ExportController;
use Illuminate\Http\Request;
use PharIo\Manifest\Library;


Route::get('/', function (Request $request) {
    // Check if search parameters are present
    if ($request->has('query') || $request->has('search_by') || $request->has('category')) {
        // Perform search
        $query = \App\Models\DocumentModel::with('category');

        $keyword = $request->input('query');
        $filter = $request->input('search_by');
        $categoryName = $request->input('category');

        if ($keyword && $filter) {
            if ($filter == 'judul') {
                $query->where('title', 'LIKE', "%{$keyword}%");
            } elseif ($filter == 'penulis') {
                $query->where('author', 'LIKE', "%{$keyword}%");
            } elseif ($filter == 'tahun') {
                $query->where('year_published', 'LIKE', "%{$keyword}%");
            }
        }

        if ($categoryName) {
            $category = \App\Models\CategoryModel::where('category_name', $categoryName)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $searchResults = $query->paginate(10)->withQueryString();
        $isSearch = true;

        return view('welcome', compact('searchResults', 'isSearch'));
    } else {
        // Show recent documents
        $recentDocuments = \App\Models\DocumentModel::with('category')->latest()->take(3)->get();
        $isSearch = false;

        return view('welcome', compact('recentDocuments', 'isSearch'));
    }
});

Route::get('/collection/{category}', [App\Http\Controllers\CollectionController::class, 'index'])->name('collection');
Route::get('/collection/view/{id}', [CollectionController::class, 'view'])->name('collection.view');
Route::get('/collection/readonly/{id}', [CollectionController::class, 'viewReadOnly'])->name('collection.readonly');
Route::get('/collectionall', [App\Http\Controllers\CollectionAllController::class, 'index'])->name('collectionall');
Route::get('/collectionall/view/{id}', [CollectionAllController::class, 'view'])->name('collectionall.view');
Route::get('/collectionall/readonly/{id}', [CollectionAllController::class, 'viewReadOnly'])->name('collectionall.readonly');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/document/readonly/{id}', [LibraryController::class, 'viewReadOnly'])
    ->name('documents.readonly');


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
    Route::get('/lihat-file/{id}', [LibraryController::class, 'viewFile'])->name('documents.view');


    // user management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');          // daftar user
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // form tambah
    Route::post('/users', [UserController::class, 'store'])->name('users.store');         // simpan user baru
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');// form edit
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // update data user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // hapus user
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/welcome', [LibraryController::class, 'index'])->name('welcome');



    Route::get('/export/buku/{month}', [ExportController::class, 'exportMonthly'])->name('book.export.monthly');

});

 Route::get('/test', function() { return 'Test route works'; });
require __DIR__.'/auth.php';
