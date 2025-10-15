<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $faculties = Faculty::whereHas('lecturers')
            ->with(['lecturers.studyProgram', 'studyPrograms'])
            ->get();
        
        return view('frontend.lecturers.index', compact('faculties'));
    }

    /**
     * Menampilkan halaman detail dosen beserta daftar dosen lain se-fakultas.
     */
    public function show(Lecturer $lecturer)
    {
        // Memuat relasi yang dibutuhkan untuk dosen utama
        $lecturer->load('faculty', 'studyProgram');

        // --- INI BAGIAN BARU ---
        // Ambil 5 dosen lain dari fakultas yang sama, secara acak.
        // Pastikan untuk tidak menampilkan dosen yang sedang dibuka.
        $relatedLecturers = collect(); // Default collection kosong
        if ($lecturer->faculty_id) {
            $relatedLecturers = Lecturer::where('faculty_id', $lecturer->faculty_id)
                ->where('id', '!=', $lecturer->id)
                ->inRandomOrder()
                ->take(5)
                ->get();
        }
        
        // Kirim semua data ke view
        return view('frontend.lecturers.show', compact('lecturer', 'relatedLecturers'));
    }
}

