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

        // Handle search
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

        $documents = $query->paginate(10)->withQueryString();

        $category = (object) ['category_name' => 'Semua Kategori'];

        return view('collection.collectionall', compact('documents', 'category'));
    }
}
