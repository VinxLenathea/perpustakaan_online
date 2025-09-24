<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use App\Models\CategoryModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    /**
     * Tampilkan halaman utama library dengan pencarian, filter, dan pagination
     */
    public function index(Request $request)
    {
        // Awali dengan query builder
        $query = DocumentModel::with(['category']);

        // 🔍 Search keyword
        if ($request->filled('keyword') && $request->filled('filter')) {
            $keyword = $request->keyword;
            $filter = $request->filter;

            if ($filter == 'judul') {
                $query->where('title', 'LIKE', "%{$keyword}%");
            } elseif ($filter == 'penulis') {
                $query->where('author', 'LIKE', "%{$keyword}%");
            } elseif ($filter == 'tahun') {
                $query->where('year_published', 'LIKE', "%{$keyword}%");
            }
        }

        // 📂 Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // ✅ Pagination (10 data per halaman)
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
        ;

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
            'file'            => 'nullable|mimes:pdf,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        $document = DocumentModel::create([
            'title'          => $request->title,
            'author'         => $request->author,
            'year_published' => $request->year_published,
            'category_id'    => $request->category_id,
            'file_url'       => $filePath,
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
            'file'            => 'nullable|mimes:pdf,png|max:2048',
        ]);

        $document->title          = $request->title;
        $document->author         = $request->author;
        $document->year_published = $request->year_published;
        $document->category_id    = $request->category_id;

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

        $document->save();

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

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }



}
