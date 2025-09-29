<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Page;
use App\Models\Post;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Kartu statistik
        $stats = [
            'posts'          => Post::count(),
            'pages'          => Page::count(),
            'lecturers'      => Lecturer::count(),
            'events'         => Event::count(),
            'faculties'      => Faculty::count(),
            'study_programs' => StudyProgram::count(),
            'announcements'  => Announcement::count(),
            'documents'      => Document::count(),
        ];

        // Data grafik 6 bulan terakhir (mulai awal bulan)
        $since = now()->subMonths(6)->startOfMonth();

        // --- MySQL/MariaDB ---
        $postsPerMonth = Post::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, COUNT(*) as count')
            ->where('created_at', '>=', $since)
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        $chartData = [
            'labels' => $postsPerMonth->map(fn ($row) => Carbon::createFromFormat('Y-m', $row->ym)->format('M Y')),
            'data'   => $postsPerMonth->pluck('count'),
        ];

        // Jika pakai PostgreSQL, ganti blok query di atas dengan:
        // $postsPerMonth = Post::selectRaw("TO_CHAR(date_trunc('month', created_at), 'YYYY-MM') as ym, COUNT(*) as count")
        //     ->where('created_at', '>=', $since)
        //     ->groupBy('ym')
        //     ->orderBy('ym')
        //     ->get();

        return view('dashboard', compact('stats', 'chartData'));
    }
}
