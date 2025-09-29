<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Post;
use App\Models\Slide;
use Illuminate\Http\Request;
use App\Models\Factoid;
use App\Models\Partner;
use App\Models\Leader;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slide::where('active', true)->orderBy('sort_order')->get();
        $latestPosts = Post::where('status', 'published')->latest()->take(3)->get();
        $upcomingEvents = Event::where('active', true)->where('start_date', '>=', now())->orderBy('start_date', 'asc')->take(3)->get();
        // ...
        $factoids = Factoid::orderBy('sort_order')->get();
        $partners = Partner::orderBy('sort_order')->get();
        $leaders = Leader::orderBy('sort_order')->get();

        return view('frontend.home', compact('sliders', 'latestPosts', 'upcomingEvents', 'factoids', 'partners', 'leaders')); // <-- Tambahkan 'factoids'

        
    }
}
