<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use App\Models\CategoryModel;
use App\Models\ClientModel;
use Illuminate\Http\Request;
use App\Models\UploadLogModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    /**
     * Tampilkan halaman utama library dengan pencarian, filter, dan pagination
     */
    public function index(Request $request)
    {
        $query = DocumentModel::with('category');

        // Search
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

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sorting berdasarkan views descending, lalu title ascending untuk handle ties
        $sortBy = $request->get('sort_by', 'views');

        switch ($sortBy) {
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
                $query->orderBy('views', 'desc')->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('views', 'desc')->orderBy('title', 'asc');
                break;
        }

        // Data
        $documents = $query->paginate(10)->withQueryString();



        $categories = CategoryModel::all();

        return view('library', compact('documents', 'categories'));
    }


    /**
     * Form tambah document
     */
    public function create()
    {
        $categories = CategoryModel::all();;

        return view('library_create', compact('categories'));
    }

    /**
     * Simpan document baru
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

        // Additional validation for categories that require abstract and cover image (all except poster)
        $category = CategoryModel::find($request->category_id);
        if ($category && $category->category_name !== 'poster') {
            $request->validate([
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'abstract'    => 'nullable|string',
            ]);
        }

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
        ]);
        // Log the upload action
        UploadLogModel::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'client_id'   => null, // admin interface
            'action'      => 'upload',
            'status'      => 'approved',
        ]);


        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Document berhasil ditambahkan!',
                'document' => $document->load('category')
            ]);
        }

        return redirect()->route('library')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Form edit document
     */
    public function edit(DocumentModel $document)
    {
        $categories = CategoryModel::all();

        return view('library_edit', compact('document', 'categories'));
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
            'file'            => 'nullable|mimes:pdf,png,jpg,jpeg|max:2048',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kampus'          => 'nullable|string|max:255',
            'prodi'           => 'nullable|string|max:255',
        ]);

        // Additional validation for categories that require abstract and cover image
        $category = CategoryModel::find($request->category_id);
        if ($category && in_array($category->category_name, ['karya tulis ilmiah', 'penelitian eksternal', 'penelitian internal'])) {
            $request->validate([
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'abstract'    => 'nullable|string',
            ]);
        }

        $document->title          = $request->title;
        $document->author         = $request->author;
        $document->year_published = $request->year_published;
        $document->category_id    = $request->category_id;
        $document->abstract       = $request->abstract;
        $document->kampus         = $request->kampus;
        $document->prodi          = $request->prodi;

        // 📂 Jika ada file baru
        if ($request->hasFile('file')) {
            // hapus file lama (jika ada)
            if ($document->file_url && Storage::disk('public')->exists($document->file_url)) {
                Storage::disk('public')->delete($document->file_url);
            }

            // simpan file baru
            $path = $request->file('file')->store('documents', 'public');
            $document->file_url = $path;
        }

        // Cover image
        if ($request->hasFile('cover_image')) {
            // hapus cover lama (jika ada)
            if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
                Storage::disk('public')->delete($document->cover_image);
            }

            // simpan cover baru
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $document->cover_image = $coverPath;
        }

        $document->save();

        // Log the update action
        UploadLogModel::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'client_id'   => null, // admin interface
            'action'      => 'update',
            'status'      => 'approved',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Data berhasil diperbarui!',
                'document' => $document->load('category') // biar category_name ikut
            ]);
        }

        // kalau bukan AJAX tetap redirect
        return redirect()->route('library')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Hapus document
     */
    public function destroy($id)
    {
        $document = DocumentModel::findOrFail($id);

        if ($document->file_url && Storage::disk('public')->exists($document->file_url)) {
            Storage::disk('public')->delete($document->file_url);
        }

        if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
            Storage::disk('public')->delete($document->cover_image);
        }

        // Log the delete action before deleting
        UploadLogModel::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'client_id'   => null, // admin interface
            'action'      => 'delete',
            'status'      => 'approved',
        ]);

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    /**
     * View file without incrementing views (for library admin view)
     */
    public function viewReadOnly($id)
    {
        $document = \App\Models\DocumentModel::findOrFail($id);

        // Increment views
        $document->increment('views');

        // Pastikan file ada
        $filePath = storage_path('app/public/' . $document->file_url);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Kirim data ke tampilan readonly dengan tombol kembali
        return view('library.readonly', compact('document') + ['showBackButton' => true]);
    }

    /**
     * View file directly (without readonly restrictions)
     */
    public function viewFile($id)
    {
        $document = DocumentModel::findOrFail($id);

        // Increment views
        $document->increment('views');

        $path = storage_path('app/public/' . $document->file_url);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($path);

        // Untuk file yang bisa ditampilkan langsung (pdf, png, jpg, gif)
        if (in_array($mimeType, ['application/pdf', 'image/png', 'image/jpeg', 'image/gif'])) {
            return response()->file($path);
        }

        // Jika tidak bisa preview (misal docx, xlsx), paksa download
        return response()->download($path);
    }

    public function storeApi(Request $request)
    {
        // 🔹 Validasi API token
        $token = $request->bearerToken();
        $client = ClientModel::where('api_token', $token)->first();

        if (! $client) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 🔹 Validasi input file (contoh minimal)
        $request->validate([
            'title' => 'required|string|max:255',
            'file_url' => 'required|string|max:255',
        ]);

        // 🔹 Simpan dokumen
        $document = documentModel::create([
            'title' => $request->title,
            'author' => $request->author,
            'year_published' => $request->year_published,
            'category_id' => $request->category_id,
            'abstract' => $request->abstract,
            'file_url' => $request->file_url,
            'client_id' => $client->id, // isi dari client yang valid
        ]);

        return response()->json([
            'message' => 'Upload berhasil, menunggu persetujuan admin',
            'document' => $document
        ]);
    }
}
