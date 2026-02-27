<?php

namespace App\Http\Controllers;

use App\Models\UploadLogModel;
use App\Models\DocumentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = UploadLogModel::with(['document', 'user', 'client'])
            ->where('status', 'pending');

        // 🔹 Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // 🔹 SORTING LOGIC - data terbaru dulu untuk pending items
        $query->orderBy('created_at', 'desc');

        $pendingUploads = $query->paginate(15)->withQueryString();

        return view('verification.index', compact('pendingUploads'));
    }

    public function viewFile($id)
    {
        $log = UploadLogModel::with('document')->findOrFail($id);

        // Pastikan log masih pending
        if ($log->status !== 'pending') {
            abort(403, 'File sudah diverifikasi');
        }

        $document = $log->document;

        // Pastikan file ada
        $filePath = storage_path('app/public/' . $document->file_url);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($filePath);

        // Untuk file yang bisa ditampilkan langsung (pdf, png, jpg, gif)
        if (in_array($mimeType, ['application/pdf', 'image/png', 'image/jpeg', 'image/gif'])) {
            return response()->file($filePath);
        }

        // Jika tidak bisa preview (misal docx, xlsx), paksa download
        return response()->download($filePath);
    }

    public function approve($id)
    {
        $log = UploadLogModel::findOrFail($id);

        // Pastikan log masih pending
        if ($log->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Upload sudah diverifikasi sebelumnya'
            ], 400);
        }

        $log->update([
            'status' => 'approved',
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Upload berhasil disetujui'
        ]);
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $log = UploadLogModel::findOrFail($id);

        // Pastikan log masih pending
        if ($log->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Upload sudah diverifikasi sebelumnya'
            ], 400);
        }

        $log->update([
            'status' => 'rejected',
            'notes' => $request->reason
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Upload berhasil ditolak'
        ]);
    }
}
