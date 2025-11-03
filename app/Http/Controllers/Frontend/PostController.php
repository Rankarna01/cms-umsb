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
        // --- UBAH QUERY INI ---
        $posts = Post::where('status', 'published')
                       ->orderByDesc('headline') // <-- TAMBAHKAN BARIS INI
                       ->latest()                 // latest() akan jadi urutan kedua
                       ->paginate(9); 
        // --------------------

        return view('frontend.posts.index', compact('posts'));
    }

    // Method untuk menampilkan satu berita secara lengkap
    public function show($slug)
    {
        $post = Post::where('status', 'published')->where('slug', $slug)->firstOrFail();

        // Query ini untuk "latestPosts" di sidebar, 
        // Anda juga bisa tambahkan headline di sini jika mau,
        // tapi biasanya sidebar tetap yang terbaru.
        $latestPosts = Post::where('status', 'published')
                             ->where('id', '!=', $post->id)
                             ->latest()
                             ->take(4)
                             ->get();
        
        $upcomingEvents = Event::where('active', true)
                                  ->where('start_date', '>=', now())
                                  ->orderBy('start_date', 'asc')
                                  ->take(3)
                                  ->get();

        return view('frontend.posts.show', compact('post', 'latestPosts', 'upcomingEvents'));
    }
}