<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Categories;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if (!allowedRoles(['admin'])) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $categories = Categories::all();
        $menus = Menu::with('category');

        if ($request->category) {
            $menus->where('id_category', $request->category);
        }

        if ($request->search) {
            $menus->where('nama_menu', 'like', '%' . $request->search . '%');
        }

        $menus = $menus->get();

        if ($request->ajax()) {
            return view('menu.table', compact('menus'))->render();
        }

        return view('menu.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_category' => 'required|exists:tb_categories,id',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['id_category', 'nama_menu', 'harga']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('menu_images'), $filename);
            $data['image'] = 'menu_images/' . $filename; // path untuk diakses dari browser
        }

        Menu::create($data);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Categories::all();
        return view('menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_category' => 'required|exists:tb_categories,id',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        $data = $request->only(['id_category', 'nama_menu', 'harga']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($menu->image && file_exists(public_path($menu->image))) {
                unlink(public_path($menu->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('menu_images'), $filename);
            $data['image'] = 'menu_images/' . $filename;
        }

        $menu->update($data);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function addStock(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'tambah_stok' => 'required|integer|min:1'
        ]);

        $menu->stok += $request->tambah_stok;
        $menu->save();

        return redirect()->back()->with('success', 'Stok berhasil ditambahkan.');
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->stok = $request->stok;
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar jika ada
        if ($menu->image && file_exists(public_path($menu->image))) {
            unlink(public_path($menu->image));
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus');
    }
}
