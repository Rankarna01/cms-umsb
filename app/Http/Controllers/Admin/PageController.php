<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * Menampilkan daftar semua halaman.
     */
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Menampilkan form untuk membuat halaman baru.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Menyimpan halaman baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:pages,title',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug', // <-- TAMBAHAN
            'header_image' => 'nullable|image|max:2048',
            'published_date' => 'nullable|date',
            'summary' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);
        // --- LOGIKA SLUG BARU ---
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            // Bersihkan slug yang diinput manual jika user mengetik spasi, dll.
            $validated['slug'] = Str::slug($validated['slug']);
        }
        $validated['active'] = $request->has('active');

        if ($request->hasFile('header_image')) {
            $path = $request->file('header_image')->store('page_headers', 'public');
            $validated['header_image'] = $path;
        }

        Page::create($validated);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit halaman.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Memperbarui halaman di database.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('pages')->ignore($page->id)],
            'content' => 'required|string',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('pages')->ignore($page->id)], // <-- TAMBAHAN
            'header_image' => 'nullable|image|max:2048',
            'published_date' => 'nullable|date',
            'summary' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);
        // --- LOGIKA SLUG BARU ---
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            // Bersihkan slug yang diinput manual jika user mengetik spasi, dll.
            $validated['slug'] = Str::slug($validated['slug']);
        }

        
        $validated['active'] = $request->has('active');

         if ($request->has('delete_header_image')) {
            if ($page->header_image) {
                Storage::delete($page->header_image); // Hapus file dari storage
            }
            $validated['header_image'] = null; // Siapkan untuk mengosongkan kolom di database
        }

        if ($request->hasFile('header_image')) {
            // Hapus gambar lama jika ada sebelum upload yang baru
            if ($page->header_image) {
                Storage::delete($page->header_image);
            }
            $path = $request->file('header_image')->store('page_headers', 'public');
            $validated['header_image'] = $path;
        }

        $page->update($validated);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }
    
    /**
     * Menghapus halaman dari database.
     */
    public function destroy(Page $page)
    {
        // Hapus juga file gambar headernya
        if ($page->header_image) {
            Storage::delete($page->header_image);
        }
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}