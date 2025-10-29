<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Post;
use App\Models\Slide;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Factoid;
use App\Models\Partner;
use App\Models\Leader;
use App\Models\QuickLink;
use App\Models\Lecturer;
use App\Models\Testimonial;
use App\Models\AcademicService;

class HomeController extends Controller
{
    public function index()
    {
        // --- Data Lain (Biarkan Saja) ---
        $sliders = Slide::where('active', true)->orderBy('sort_order')->get();
        $upcomingEvents = Event::where('active', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();
        $factoids = Factoid::orderBy('sort_order')->get();
        $leaders = Leader::orderBy('sort_order')->get();
        $partners = Partner::orderBy('sort_order')->get();
        $galleryPhotos = Photo::latest()->paginate(8);
        $totalPhotos = Photo::count();
        $latestVideos = Video::latest()->take(3)->get();
        $quickLinks = QuickLink::orderBy('sort_order')->get();
        $testimonials = Testimonial::where('active', true)->orderBy('sort_order')->take(4)->get();
        $academicServices = AcademicService::orderBy('sort_order')->get();
        $latestLecturers = Lecturer::latest()->take(4)->get();
        $latestAnnouncements = Announcement::where('active', true)->latest('published_at')->take(4)->get();
        $latestEvents = Event::where('active', true)->latest('start_date')->take(5)->get();


        // ---------------------------------
        // [ LOGIKA BERITA - VERSI BARU UNTUK TES ]
        // ---------------------------------
        // 1. Ambil semua kategori yang 'active'
        // 2. DAN HANYA yang 'memiliki' (whereHas) postingan berstatus 'published'
        // 3. 'Sertakan' (with) postingan tersebut, tapi...
        // 4. Batasi HANYA 5 postingan 'published' terbaru per kategori
        
        $categoriesWithPosts = PostCategory::where('active', true)
            ->whereHas('posts', function ($query) {
                $query->where('status', 'published');
            })
            ->with(['posts' => function ($query) {
                $query->where('status', 'published')
                      ->latest()
                      ->take(3); // <-- MENJADI 3
            }])
            ->orderBy('name', 'asc') // Urutkan kategori berdasarkan nama A-Z
            ->get();


        // Kirim ke view
        return view('frontend.home', compact(
            'sliders',
            'upcomingEvents',
            'factoids',
            'leaders',
            'partners',
            // Variabel berita lama ($featuredPost, $otherPosts) HILANG
            // Kita ganti dengan variabel baru:
            'categoriesWithPosts', // <-- INI VARIABEL BARU KITA
            'galleryPhotos',
            'latestVideos',
            'quickLinks',
            'latestLecturers',
            'testimonials',
            'latestAnnouncements', // <-- TAMBAHKAN INI
            'latestEvents',        // <-- TAMBAHKAN INI
            'academicServices'
        ));
    }
}