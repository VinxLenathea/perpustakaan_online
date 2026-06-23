<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categoryModel;
use App\Models\documentModel;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung hanya dokumen yang approved
        $totalDocuments    = documentModel::where('status', 'approved')->count();
        $approvedDocuments = documentModel::where('status', 'approved')->count();
        $pendingDocuments  = documentModel::where('status', 'pending')->count();
        $rejectedDocuments = documentModel::where('status', 'rejected')->count();

        // Hitung dokumen per kategori hanya yang approved
        $categories = categoryModel::withCount(['documents' => function ($q) {
            $q->where('status', 'approved');
        }])->get();

        $recentPending = documentModel::where('status', 'pending')
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
