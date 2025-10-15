<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Album; // Ini adalah model Kategori kita
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::with('album')->latest()->get();
        return view('admin.photos.index', compact('photos'));
    }

    public function create()
    {
        $categories = Album::orderBy('title')->get();
        return view('admin.photos.create', compact('categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'nullable|string|max:255', // <-- Pastikan ini ada
        'image_path' => 'required|image|max:2048',
        'album_id' => 'required|exists:albums,id',
    ]);

    $path = $request->file('image_path')->store('public/gallery');
    $validated['image_path'] = $path;

    Photo::create($validated); // Perintah ini sekarang akan menyimpan 'title'

    return redirect()->route('admin.photos.index')->with('success', 'Foto berhasil diupload.');
}

    public function destroy(Photo $photo)
    {
        Storage::delete($photo->image_path);
        $photo->delete();
        return redirect()->route('admin.photos.index')->with('success', 'Foto berhasil dihapus.');
    }
}