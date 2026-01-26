<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use Illuminate\Http\Request;

class WellcomeController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil 5 dokumen yang paling banyak dilihat, diurutkan berdasarkan views descending, lalu title ascending
        $topViewedDocuments = DocumentModel::with('category')
            ->orderBy('views', 'desc')
            ->orderBy('title', 'asc')
            ->limit(5)
            ->get();

        // Mengirimkan data ke view
        return view('welcome', compact('topViewedDocuments'));
    }
}
