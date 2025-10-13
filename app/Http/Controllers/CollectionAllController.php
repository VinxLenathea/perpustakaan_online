<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentModel;
use App\Models\CategoryModel;

class CollectionAllController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentModel::with('category');

        // 🔍 Handle search
        if ($request->has('query') && $request->query) {
            $keyword = $request->input('query');
            $filter = $request->input('search_by');
            $categoryName = $request->input('category');

            if ($keyword && $filter) {
                if ($filter == 'judul') {
                    $query->where('title', 'LIKE', "%{$keyword}%");
                } elseif ($filter == 'penulis') {
                    $query->where('author', 'LIKE', "%{$keyword}%");
                } elseif ($filter == 'tahun') {
                    $query->where('year_published', 'LIKE', "%{$keyword}%");
                }
            }

            if ($categoryName) {
                $category = CategoryModel::where('category_name', $categoryName)->first();
                if ($category) {
                    $query->where('category_id', $category->id);
                }
            }
        }

        // 📌 Sorting
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'tahun_desc': // Tahun terbaru
                    $query->orderBy('year_published', 'desc');
                    break;

                case 'tahun_asc': // Tahun terlama
                    $query->orderBy('year_published', 'asc');
                    break;

                case 'judul_asc': // Judul A-Z
                    $query->orderBy('title', 'asc');
                    break;

                case 'judul_desc': // Judul Z-A
                    $query->orderBy('title', 'desc');
                    break;

                case 'views': // Paling sering dibaca
                    $query->orderBy('views', 'desc');
                    break;

                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $documents = $query->paginate(10)->withQueryString();

        $category = (object) ['category_name' => 'Semua Kategori'];

        return view('collection.collectionall', compact('documents', 'category'));
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
}
