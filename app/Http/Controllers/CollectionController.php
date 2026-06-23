<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\DocumentModel;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index($category_name, Request $request)
    {
        $category   = CategoryModel::where('category_name', $category_name)->firstOrFail();
        $categories = CategoryModel::all(); // ← tambah ini

        $query = DocumentModel::where('category_id', $category->id)
            ->where('status', 'approved') // ← hanya yang approved
            ->with('category');

        // Handle search — sesuaikan dengan nama parameter di form
        if ($request->filled('query')) {
            $keyword = $request->input('query');
            $filter  = $request->input('search_by', 'judul');

            switch ($filter) {
                case 'judul':
                    $query->where('title', 'like', '%' . $keyword . '%');
                    break;
                case 'penulis':
                    $query->where('author', 'like', '%' . $keyword . '%');
                    break;
                case 'tahun':
                    $query->where('year_published', 'like', '%' . $keyword . '%');
                    break;
            }
        }

        if ($request->filled('category')) {
            $filterCategory = CategoryModel::where('category_name', $request->category)->first();
            if ($filterCategory) {
                $query->where('category_id', $filterCategory->id);
            }
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
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
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $documents = $query->paginate(10)->withQueryString(); // ← tambah withQueryString

        return view('collection.collection', compact('documents', 'category', 'categories'));
    }

    public function view($id)
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

    /**
     * View file in readonly mode (without incrementing views)
     */
    public function viewReadOnly($id)
    {
        $document = DocumentModel::findOrFail($id);

        // Increment views
        $document->increment('views');

        // Pastikan file ada
        $filePath = storage_path('app/public/' . $document->file_url);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Kirim data ke tampilan readonly tanpa tombol kembali
        return view('library.readonly', compact('document') + ['showBackButton' => false]);
    }
}
