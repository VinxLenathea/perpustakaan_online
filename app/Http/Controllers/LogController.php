<?php

namespace App\Http\Controllers;

use App\Models\UploadLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = UploadLogModel::with(['document', 'user', 'client']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $logs = $query->paginate(15);

        return view('logs', compact('logs'));
    }

    public function approve($id)
    {
        $log = UploadLogModel::findOrFail($id);
        $log->update(['status' => 'approved']);

        return response()->json(['message' => 'Log berhasil diapprove']);
    }

    public function reject($id)
    {
        $log = UploadLogModel::findOrFail($id);
        $log->update(['status' => 'rejected']);

        return response()->json(['message' => 'Log berhasil direject']);
    }
}
