<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlideImage;
use Illuminate\Support\Facades\Storage;

class SlideImageController extends Controller
{
    public function destroy(SlideImage $image)
    {
        // Simpan ID slide untuk redirect balik
        $slideId = $image->slide_id;

        // Hapus file fisik di storage
        Storage::disk('public')->delete($image->image_path);

        // Hapus data di database
        $image->delete();

        // Kembali ke halaman edit slider terkait
        return redirect()
            ->route('admin.sliders.edit', $slideId)
            ->with('success', 'Gambar berhasil dihapus.');
    }
}
