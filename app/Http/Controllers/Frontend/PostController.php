<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Method untuk menampilkan halaman daftar semua berita
    public function index()
    {
        $posts = Post::where('status', 'published')->latest()->paginate(9); // Ambil 9 berita per halaman
        return view('frontend.posts.index', compact('posts'));
    }

    // Method untuk menampilkan satu berita secara lengkap
    public function show($slug)
    {
        $post = Post::where('status', 'published')->where('slug', $slug)->firstOrFail();
        // firstOrFail() akan otomatis menampilkan halaman 404 jika berita tidak ditemukan
        return view('frontend.posts.show', compact('post'));
    }
}