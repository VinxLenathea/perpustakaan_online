<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentModel;

class CollectionAllController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentModel::with('category');

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

        $documents = $query->paginate(10);

        $category = (object) ['category_name' => 'Semua Kategori'];

        return view('collection.collectionall', compact('documents', 'category'));
    }
}
