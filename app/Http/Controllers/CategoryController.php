<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::all();
        return view('categories', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // ✅ FIX: Ubah 'name' jadi 'category_name' sesuai form
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
            'category_type' => 'required|in:internal,external', // Validasi untuk category_type
        ]);

        $category = CategoryModel::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'category' => $category
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = CategoryModel::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $id,
            'category_type' => 'required|in:internal,external', // Validasi untuk category_type
        ]);

        $category = CategoryModel::findOrFail($id);
        $category->update($validated); // ✅ Lebih clean pakai update()

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Kategori berhasil diperbarui!',
                'category' => $category
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus!',
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}