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

        $path = $request->file('upload')->store('public/editor_images');

        // CKEditor mengharapkan 'url', TinyMCE mengharapkan 'location'.
        // Kita bisa akali ini di JavaScript, atau ubah di sini agar lebih universal.
        // Mari kita ubah di sini agar bisa dipakai keduanya.
        $url = \Storage::url($path);

        return response()->json([
            'url' => $url,
            'location' => $url 
        ]);
    }
}