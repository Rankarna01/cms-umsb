<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $latestAnnouncements = Announcement::where('active', true)
            ->latest('published_at')->take(5)->get();

        $latestEvents = Event::where('active', true)
            ->where('id', '!=', $event->id)
            ->latest('start_date')->take(5)->get();

        return view('frontend.page.event_show', compact(
            'event', 'latestAnnouncements', 'latestEvents'
        ));
    }
}
