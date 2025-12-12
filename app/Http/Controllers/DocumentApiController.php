<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use App\Models\ClientModel;
use App\Models\UploadLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentApiController extends Controller
{
    /**
     * Upload dokumen melalui API
     */
    public function upload(Request $request)
    {
        // Validasi API token
        $token = $request->bearerToken();
        $client = ClientModel::where('api_token', $token)->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Token API tidak valid'
            ], 401);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'category_id' => 'required|exists:categories,id',
            'abstract' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // max 10MB
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'kampus' => 'nullable|string|max:255',
            'prodi' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan file dokumen
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        // Simpan cover image
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        // Buat dokumen baru dengan status pending
        $document = DocumentModel::create([
            'title' => $request->title,
            'author' => $request->author,
            'year_published' => $request->year_published,
            'category_id' => $request->category_id,
            'abstract' => $request->abstract,
            'file_url' => $filePath,
            'cover_image' => $coverPath,
            'kampus' => $request->kampus,
            'prodi' => $request->prodi,
            'views' => 0,
            'client_id' => $client->id,
            'status' => 'pending'
        ]);

        // Log upload
        UploadLogModel::create([
            'document_id' => $document->id,
            'user_id' => null, // API upload, tidak ada user
            'client_id' => $client->id,
            'action' => 'upload',
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diupload, menunggu persetujuan admin',
            'data' => [
                'document_id' => $document->id,
                'title' => $document->title,
                'status' => $document->status
            ]
        ], 201);
    }
}
