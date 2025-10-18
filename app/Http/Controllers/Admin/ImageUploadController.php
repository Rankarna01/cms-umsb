<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $request->file('upload')->store('editor_images', 'public');

// Dapatkan URL file yang bisa diakses publik
$url = \Storage::url($path);


        return response()->json([
            'url' => $url,
            'location' => $url 
        ]);
    }
}