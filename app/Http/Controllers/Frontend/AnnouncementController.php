<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event; // Untuk sidebar

class AnnouncementController extends Controller
{
    /**
     * Menampilkan halaman detail pengumuman.
     */
    public function show(Announcement $announcement)
    {
        // Ambil data untuk sidebar
        $latestAnnouncements = Announcement::where('active', true)
                                ->where('id', '!=', $announcement->id) // Jangan tampilkan yang sedang dibuka
                                ->latest('published_at')
                                ->take(5)
                                ->get();
                                
        $latestEvents = Event::where('active', true)
                                ->latest('start_date')
                                ->take(5)
                                ->get();

        return view('frontend.page.announcement_show', compact(
            'announcement', 
            'latestAnnouncements', 
            'latestEvents'
        ));
    }
}