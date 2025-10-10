<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\DocumentModel;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index($category_name, Request $request)
    {
        $category = CategoryModel::where('category_name', $category_name)->firstOrFail();

        $query = DocumentModel::where('category_id', $category->id)->with('category');

        // Handle search
        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $filter = $request->filter ?? 'judul';

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

        $documents = $query->paginate(10);

        return view('collection.collection', compact('documents', 'category'));
    }

    public function view($id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->increment('views');
        return redirect(asset('storage/' . $document->file_url));
    }
}
