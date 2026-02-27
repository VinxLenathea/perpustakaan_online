<?php

namespace App\Http\Controllers;

use App\Models\UploadLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = UploadLogModel::with(['document', 'user', 'client', 'verifier']);

        // 🔹 Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 🔹 Filter berdasarkan tanggal
        $useDateFilter = false;

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
            $useDateFilter = true;
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
            $useDateFilter = true;
        }

        // 🔹 SORTING LOGIC
        if ($useDateFilter) {
            // Kalau pakai filter tanggal → urut dari lama ke baru
            $query->orderBy('created_at', 'asc');
        } else {
            // Default → data terbaru dulu
            $query->orderBy('created_at', 'desc');
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('logs', compact('logs'));
    }

    public function approve($id)
    {
        $log = UploadLogModel::findOrFail($id);
        $log->update([
            'status' => 'approved',
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        return response()->json([
            'message' => 'Log berhasil diapprove'
        ]);
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $log = UploadLogModel::findOrFail($id);
        $log->update([
            'status' => 'rejected',
            'notes' => $request->reason,
            'verified_by' => Auth::id(),
            'verified_at' => now()
        ]);

        return response()->json([
            'message' => 'Log berhasil direject'
        ]);
    }
}
