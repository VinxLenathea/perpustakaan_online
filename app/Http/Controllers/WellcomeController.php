<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use Illuminate\Http\Request;

class WellcomeController extends Controller
{
    public function index(Request $request)
    {
        $topViewedDocuments = DocumentModel::with('category')
            ->where('status', 'approved')
            ->orderBy('views', 'desc')
            ->orderBy('title', 'asc')
            ->limit(3)
            ->get();

            dd(
                $topViewedDocuments->count(),
                $topViewedDocuments->pluck('id', 'title')
            );

        // Mengirimkan data ke view
        return view('welcome', compact('topViewedDocuments'));
    }
}
