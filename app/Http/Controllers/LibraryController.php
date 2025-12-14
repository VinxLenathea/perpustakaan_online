<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use App\Models\CategoryModel;
use App\Models\ClientModel;
use App\Models\UploadLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    /**
     * Tampilkan halaman utama library
     */
    public function index(Request $request)
    {
        $query = DocumentModel::with('category');

        // 🔍 SEARCH
        if ($request->filled('keyword') && $request->filled('filter')) {
            $key = $request->keyword;
            $filter = $request->filter;

            if ($filter === 'judul') {
                $query->where('title', 'LIKE', "%{$key}%");
            } elseif ($filter === 'penulis') {
                $query->where('author', 'LIKE', "%{$key}%");
            } elseif ($filter === 'tahun') {
                $query->where('year_published', 'LIKE', "%{$key}%");
            }
        }

        // 🎯 FILTER KATEGORI
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 🔥 SORTING (DEFAULT = TERBARU)
        $sortBy = $request->get('sort_by', 'terbaru');

        switch ($sortBy) {
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;

            case 'tahun_desc':
                $query->orderBy('year_published', 'desc');
                break;

            case 'tahun_asc':
                $query->orderBy('year_published', 'asc');
                break;

            case 'judul_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'judul_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'views':
                $query->orderBy('views', 'desc')
                      ->orderBy('created_at', 'desc'); // tie breaker
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 📄 DATA
        $documents = $query->paginate(10)->withQueryString();
        $categories = CategoryModel::all();

        return view('library', compact('documents', 'categories'));
    }

    /**
     * Form tambah document
     */
    public function create()
    {
        $categories = CategoryModel::all();
        return view('library_create', compact('categories'));
    }

    /**
     * Simpan document baru (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'author'          => 'required|string|max:255',
            'year_published'  => 'required|integer|min:1900|max:2099',
            'category_id'     => 'required|exists:categories,id',
            'file'            => 'nullable|mimes:pdf,png,jpg,jpeg|max:10240',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'abstract'        => 'nullable|string',
            'kampus'          => 'nullable|string|max:255',
            'prodi'           => 'nullable|string|max:255',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        $document = DocumentModel::create([
            'title'          => $request->title,
            'author'         => $request->author,
            'year_published' => $request->year_published,
            'category_id'    => $request->category_id,
            'file_url'       => $filePath,
            'cover_image'    => $coverPath,
            'abstract'       => $request->abstract,
            'kampus'         => $request->kampus,
            'prodi'          => $request->prodi,
            'views'          => 0
        ]);

        UploadLogModel::create([
            'document_id' => $document->id,
            'user_id'     => Auth::id(),
            'client_id'   => null,
            'action'      => 'upload',
            'status'      => 'approved',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Document berhasil ditambahkan!',
                'document' => $document->load('category')
            ]);
        }

        return redirect()->route('library')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update document
     */
    public function update(Request $request, DocumentModel $document)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'author'          => 'required|string|max:255',
            'year_published'  => 'required|integer|min:1900|max:2099',
            'category_id'     => 'required|exists:categories,id',
            'abstract'        => 'nullable|string',
            'file'            => 'nullable|mimes:pdf,png,jpg,jpeg|max:10240',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kampus'          => 'nullable|string|max:255',
            'prodi'           => 'nullable|string|max:255',
        ]);

        $document->update($request->only([
            'title','author','year_published','category_id','abstract','kampus','prodi'
        ]));

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_url);
            $document->file_url = $request->file('file')->store('documents', 'public');
        }

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($document->cover_image);
            $document->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        $document->save();

        UploadLogModel::create([
            'document_id' => $document->id,
            'user_id'     => Auth::id(),
            'client_id'   => null,
            'action'      => 'update',
            'status'      => 'approved',
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Upload via API (SIAKAD)
     */
    public function storeApi(Request $request)
    {
        $token = $request->bearerToken();
        $client = ClientModel::where('api_token', $token)->first();

        if (!$client) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'nullable|string|max:255',
            'year_published' => 'nullable|integer',
            'abstract'       => 'nullable|string',
            'file_url'       => 'required|string',
            'kampus'         => 'nullable|string',
            'prodi'          => 'nullable|string',
        ]);

        $document = DocumentModel::create([
            'title'          => $request->title,
            'author'         => $request->author,
            'year_published' => $request->year_published,
            'category_id'    => 3, // 🔒 kunci kategori perpustakaan
            'abstract'       => $request->abstract,
            'file_url'       => $request->file_url,
            'kampus'         => $request->kampus,
            'prodi'          => $request->prodi,
            'client_id'      => $client->id,
            'views'          => 0,
            'status'         => 'pending'
        ]);

        UploadLogModel::create([
            'document_id' => $document->id,
            'client_id'   => $client->id,
            'action'      => 'upload',
            'status'      => 'pending'
        ]);

        return response()->json([
            'message' => 'Upload berhasil, menunggu persetujuan admin',
            'document_id' => $document->id
        ], 201);
    }
}
