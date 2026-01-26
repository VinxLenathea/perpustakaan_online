<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\CategoryModel::all();
        return view('categories', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,category_name',
        ]);

        $category = \App\Models\CategoryModel::create([
            'category_name' => $request->name,
        ]);

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
        $category = \App\Models\CategoryModel::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category = \App\Models\categoryModel::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category successfully updated!',
                'category' => $category
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category successfully updated!');
    }

    public function destroy(Request $request, $id)
    {
        $category = \App\Models\CategoryModel::findOrFail($id);
        $category->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category successfully deleted!',
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted!');
    }
}
