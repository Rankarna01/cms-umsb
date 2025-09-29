<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <-- IMPORT CLASS Str UNTUK SLUG
use Illuminate\Validation\Rule; // <-- IMPORT CLASS Rule UNTUK VALIDASI UNIQUE


class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $categories = PostCategory::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        // Cukup tampilkan view form-nya
        return view('admin.categories.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:post_categories,slug',
            'type' => 'required|in:news,information',
            'active' => 'required|boolean',
        ]);

        // 2. Proses Slug (jika kosong, buat otomatis)
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // 3. Simpan ke Database
        PostCategory::create($validated);

        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    // Menampilkan form edit data
    public function edit(PostCategory $category)
    {
        // Kirim data kategori yang mau diedit ke view
        return view('admin.categories.create', compact('category'));
    }

    // Memperbarui data di database
    public function update(Request $request, PostCategory $category)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('post_categories')->ignore($category->id)],
            'type' => 'required|in:news,information',
            'active' => 'required|boolean',
        ]);

        // 2. Proses Slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // 3. Update data
        $category->update($validated);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus data (kita siapkan dulu, eksekusi nanti)
    public function destroy(PostCategory $category)
    {
        // Hapus data dari database
        $category->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
