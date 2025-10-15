<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Event; 
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

        $latestPosts = Post::where('status', 'published')
                            ->where('id', '!=', $post->id)
                            ->latest()
                            ->take(4)
                            ->get();

        // --- TAMBAHKAN BLOK INI ---
        // Ambil 3 agenda terdekat
        $upcomingEvents = Event::where('active', true)
                                ->where('start_date', '>=', now())
                                ->orderBy('start_date', 'asc')
                                ->take(3)
                                ->get();
        // -------------------------

        // --- Perbarui baris return ---
        return view('frontend.posts.show', compact('post', 'latestPosts', 'upcomingEvents'));
    }
}