<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Photo; // <-- PERBAIKAN: Ganti dari 'GalleryPhoto' menjadi 'Photo'
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Gunakan model 'Photo' yang benar
        $photos = Photo::with('album')->latest()->paginate(12); 
        return view('frontend.gallery.index', compact('photos'));
    }
}
