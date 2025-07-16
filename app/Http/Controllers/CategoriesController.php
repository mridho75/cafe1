<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        if (!allowedRoles(['admin'])) {
            return redirect('/')->with('error', 'Akses hanya untuk Admin!');
        }

        $categories = Categories::all();
        return view('category.index', compact('categories'));
    }

    // Menampilkan form untuk membuat kategori
    public function create()
    {
        return view('category.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        Categories::create($request->all());
        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit kategori
    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        $category = Categories::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        Categories::destroy($id);
        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
