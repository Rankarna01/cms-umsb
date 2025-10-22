<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\QuickLink;


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

         $quickLinks = QuickLink::orderBy('sort_order')->get();
        // 4. Kirim semua data ke view
        return view('frontend.page.show', compact('page', 'latestPosts', 'upcomingEvents', 'quickLinks'));
    }

    public function showPmb()
    {
        // 1. Ambil konten utama dari halaman 'Penerimaan Mahasiswa Baru'
        $page = Page::where('slug', 'penerimaan-mahasiswa-baru')->firstOrFail();

        // 2. Ambil semua data dari 'Link Cepat' untuk sidebar
        $quickLinks = QuickLink::orderBy('sort_order')->get();

        // 3. Kirim kedua data ke view baru
        return view('frontend.page.pmb', compact('page', 'quickLinks'));
    }
}
