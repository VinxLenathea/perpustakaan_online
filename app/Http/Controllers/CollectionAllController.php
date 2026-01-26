<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentModel;
use App\Models\CategoryModel;
use App\Models\UploadLogModel;

class CollectionAllController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentModel::with('category')
            ->whereHas('uploadLogs', function ($q) {
                $q->where('status', 'approved');
            });


        // 🔍 Handle search
        if ($request->filled('query')) {
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
                    $query->orderBy('views', 'desc');
                    break;
            }
        } else {
            // ✅ default: paling banyak dilihat
            $query->orderBy('views', 'desc');
        }

        $documents = $query->paginate(10)->withQueryString();

        $category = (object) ['category_name' => 'Semua Kategori'];

        return view('collection.collectionall', compact('documents', 'category'));
    }

    public function view($id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->increment('views');

        $path = storage_path('app/public/' . $document->file_url);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($path);

        if (in_array($mimeType, ['application/pdf', 'image/png', 'image/jpeg', 'image/gif'])) {
            return response()->file($path);
        }

        return response()->download($path);
    }

    public function viewReadOnly($id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->increment('views');

        $filePath = storage_path('app/public/' . $document->file_url);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return view('library.readonly', compact('document') + ['showBackButton' => false]);
    }
}
