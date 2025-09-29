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

        $documents = $query->get();

        return view('collection.collection', compact('documents', 'category'));
    }
}
