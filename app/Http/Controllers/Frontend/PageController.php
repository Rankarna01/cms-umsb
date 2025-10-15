<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        // 1. Ambil data halaman yang sedang dibuka
        $page = Page::where('active', true)->where('slug', $slug)->firstOrFail();

        // 2. Ambil 4 berita terbaru untuk sidebar
        $latestPosts = Post::where('status', 'published')
                            ->latest()
                            ->take(4)
                            ->get();

        // 3. Ambil 3 agenda terdekat untuk sidebar
        $upcomingEvents = Event::where('active', true)
                                ->where('start_date', '>=', now())
                                ->orderBy('start_date', 'asc')
                                ->take(3)
                                ->get();

        // 4. Kirim semua data ke view
        return view('frontend.page.show', compact('page', 'latestPosts', 'upcomingEvents'));
    }
}
