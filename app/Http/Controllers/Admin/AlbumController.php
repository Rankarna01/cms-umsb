<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Album; // Tetap pakai model Album, tapi fungsinya jadi Kategori
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Album::latest()->get();
        return view('admin.albums.index-category', compact('categories'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('admin.albums.create-category');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate(['title' => 'required|string|max:255|unique:albums,title']);
        Album::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
        ]);
        return redirect()->route('admin.albums.index')->with('success', 'Kategori Galeri berhasil dibuat.');
    }

    // Hapus kategori
    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('admin.albums.index')->with('success', 'Kategori Galeri berhasil dihapus.');
    }
}