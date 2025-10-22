<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Post;
use App\Models\Slide;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Factoid;
use App\Models\Partner;
use App\Models\Leader;
use App\Models\QuickLink; //
use App\Models\Lecturer;
use App\Models\Testimonial;
use App\Models\AcademicService;


class HomeController extends Controller
{
    public function index()
    {
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
        $totalPhotos = Photo::count(); // <-- Variabel ini sekarang ada di atas
        $latestVideos = Video::latest()->take(3)->get();
        $quickLinks = QuickLink::orderBy('sort_order')->get();
        $testimonials = Testimonial::where('active', true)->orderBy('sort_order')->take(4)->get();
        $academicServices = AcademicService::orderBy('sort_order')->get();

        // -------------------------------
        // LOGIKA BERITA (robust + fallback)
        // -------------------------------

        // Kategori bertipe 'news'
        $newsCategoryIds = PostCategory::where('type', 'news')->pluck('id');
        

        // 1) Featured: prioritaskan dari kategori 'news'
        $featuredPost = Post::where('status', 'published')
            ->when($newsCategoryIds->isNotEmpty(), fn ($q) => $q->whereIn('category_id', $newsCategoryIds))
            ->latest()
            ->first();

        // Fallback featured: jika belum ada post 'news', ambil post published terbaru apa pun
        if (!$featuredPost) {
            $featuredPost = Post::where('status', 'published')
                ->latest()
                ->first();
        }

        $latestLecturers = Lecturer::latest()->take(4)->get();

        // Jika belum ada post sama sekali, pastikan otherPosts koleksi kosong agar view tetap aman
        if (!$featuredPost) {
            $otherPosts = collect();
            return view('frontend.home', compact(
                'sliders',
                'upcomingEvents',
                'factoids',
                'leaders',
                'partners',
                'featuredPost',
                'otherPosts',
                
                
            ));
        }

        // 2) Target total other posts = 7
        $target = 7;

        // Ambil non-news terlebih dahulu (utamakan sesuai requirement awal)
        $nonNews = Post::where('status', 'published')
            ->where('id', '!=', $featuredPost->id)
            ->when($newsCategoryIds->isNotEmpty(), fn ($q) => $q->whereNotIn('category_id', $newsCategoryIds))
            ->latest()
            ->take($target)
            ->get();

        // Siapkan daftar ID untuk dikecualikan saat backfill
        $excludeIds = collect([$featuredPost->id])
            ->merge($nonNews->pluck('id'))
            ->unique()
            ->values()
            ->all();

        // Backfill jika non-news kurang dari target
        if ($nonNews->count() < $target) {
            $need = $target - $nonNews->count();
            $backfill = collect();

            // 2a) Coba isi dari kategori 'news' (kecuali featured)
            if ($newsCategoryIds->isNotEmpty()) {
                $backfill = Post::where('status', 'published')
                    ->whereIn('category_id', $newsCategoryIds)
                    ->whereNotIn('id', $excludeIds)
                    ->latest()
                    ->take($need)
                    ->get();
            }

            // 2b) Jika masih kurang, isi dari post apa pun (kecuali yang sudah terambil)
            $stillNeed = $need - $backfill->count();
            if ($stillNeed > 0) {
                $excludeMore = array_merge($excludeIds, $backfill->pluck('id')->all());
                $extra = Post::where('status', 'published')
                    ->whereNotIn('id', $excludeMore)
                    ->latest()
                    ->take($stillNeed)
                    ->get();
                $backfill = $backfill->concat($extra);
            }

            $otherPosts = $nonNews->concat($backfill);
        } else {
            $otherPosts = $nonNews;
        }

        // Kirim ke view
        return view('frontend.home', compact(
            'sliders',
            'upcomingEvents',
            'factoids',
            'leaders',
            'partners',
            'featuredPost',
            'otherPosts',
            'galleryPhotos',
            'latestVideos',
            'quickLinks',
            'latestLecturers',
            'testimonials',
            'academicServices'
        ));
    }
}
