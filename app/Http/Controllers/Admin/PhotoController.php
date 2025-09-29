<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    // Form untuk upload foto ke album tertentu
    public function create(Album $album)
    {
        return view('admin.photos.create', compact('album'));
    }

    // Proses menyimpan foto
    public function store(Request $request, Album $album)
    {
        $request->validate([
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        foreach ($request->file('photos') as $file) {
            $path = $file->store('public/photos');
            $album->photos()->create(['image_path' => $path]);
        }
        
        // Atur foto pertama sebagai cover album jika belum ada
        if (!$album->cover_image && $album->photos()->first()) {
            $album->update(['cover_image' => $album->photos()->first()->image_path]);
        }

        return redirect()->route('admin.albums.show', $album)->with('success', 'Foto berhasil diupload.');
    }

    // Proses menghapus satu foto
    public function destroy(Photo $photo)
    {
        $album = $photo->album;
        Storage::delete($photo->image_path);
        $photo->delete();

        return redirect()->route('admin.albums.show', $album)->with('success', 'Foto berhasil dihapus.');
    }
}