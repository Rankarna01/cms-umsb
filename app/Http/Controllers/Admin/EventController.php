<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement; // Untuk sidebar
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Menampilkan halaman detail agenda.
     */
    public function show(Event $event)
    {
        // Ambil data untuk sidebar
        $latestAnnouncements = Announcement::where('active', true)
                                ->latest('published_at')
                                ->take(5)
                                ->get();
                                
        $latestEvents = Event::where('active', true)
                                ->where('id', '!=', $event->id) // Jangan tampilkan yang sedang dibuka
                                ->latest('start_date')
                                ->take(5)
                                ->get();

        // Mengirim data event lengkap dan data sidebar ke view
        return view('frontend.page.event_show', compact(
            'event', 
            'latestAnnouncements', 
            'latestEvents'
        ));
    }
}
