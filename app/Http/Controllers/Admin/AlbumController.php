<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::withCount('photos')->latest()->get();
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.albums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('public/album_covers');
            $validated['cover_image'] = $path;
        }

        Album::create($validated);
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil dibuat.');
    }

    public function show(Album $album)
    {
        // Tampilkan detail album dan semua fotonya
        $photos = $album->photos()->latest()->get();
        return view('admin.albums.show', compact('album', 'photos'));
    }

    public function edit(Album $album)
    {
        return view('admin.albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('cover_image')) {
            if($album->cover_image) Storage::delete($album->cover_image);
            $path = $request->file('cover_image')->store('public/album_covers');
            $validated['cover_image'] = $path;
        }

        $album->update($validated);
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Album $album)
    {
        if($album->cover_image) Storage::delete($album->cover_image);
        // Hapus semua file foto di dalam album
        foreach ($album->photos as $photo) {
            Storage::delete($photo->image_path);
        }
        $album->delete(); // Ini akan menghapus album dan semua relasi fotonya (cascade)
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil dihapus.');
    }
}