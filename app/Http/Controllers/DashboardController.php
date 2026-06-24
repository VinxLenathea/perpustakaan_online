<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\DocumentModel;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung hanya dokumen yang approved
        $totalDocuments    = DocumentModel::where('status', 'approved')->count();
        $approvedDocuments = DocumentModel::where('status', 'approved')->count();
        $pendingDocuments  = DocumentModel::where('status', 'pending')->count();
        $rejectedDocuments = DocumentModel::where('status', 'rejected')->count();

        // Hitung dokumen per kategori hanya yang approved
        $categories = CategoryModel::withCount(['documents' => function ($q) {
            $q->where('status', 'approved');
        }])->get();

        $recentPending = DocumentModel::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalDocuments',
            'approvedDocuments',
            'pendingDocuments',
            'rejectedDocuments',
            'categories',
            'recentPending'
        ));
    }
}
