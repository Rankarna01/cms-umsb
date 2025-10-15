<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturers = Lecturer::with(['faculty', 'studyProgram'])->latest()->get();
        return view('admin.lecturers.index', compact('lecturers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::where('active', true)->orderBy('name')->get();
        $studyPrograms = StudyProgram::where('active', true)->orderBy('name')->get();
        return view('admin.lecturers.create', compact('faculties', 'studyPrograms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nidn' => 'nullable|string|max:255|unique:lecturers,nidn',
            'nik' => 'nullable|string|max:255',
            'nbm' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255', // Bidang Ilmu
            'faculty_id' => 'nullable|exists:faculties,id',
            'study_program_id' => 'nullable|exists:study_programs,id', // Homebase
            'functional_position' => 'nullable|string|max:255', // Jabatan Fungsional
            'photo' => 'nullable|image|max:1024', // Max 1MB
            'link_pddikti' => 'nullable|url',
            'link_sinta' => 'nullable|url',
            'link_scholar' => 'nullable|url',
            'active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/lecturer-photos');
            $validated['photo'] = $path;
        }

        $validated['active'] = $request->has('active');
        Lecturer::create($validated);

        return redirect()->route('admin.lecturers.index')->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        $faculties = Faculty::where('active', true)->orderBy('name')->get();
        $studyPrograms = StudyProgram::where('active', true)->orderBy('name')->get();
        return view('admin.lecturers.edit', compact('lecturer', 'faculties', 'studyPrograms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nidn' => 'nullable|string|max:255|unique:lecturers,nidn,' . $lecturer->id,
            'nik' => 'nullable|string|max:255',
            'nbm' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'faculty_id' => 'nullable|exists:faculties,id',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'functional_position' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:1024',
            'link_pddikti' => 'nullable|url',
            'link_sinta' => 'nullable|url',
            'link_scholar' => 'nullable|url',
            'active' => 'nullable|boolean',
        ]);
        
        if ($request->hasFile('photo')) {
            if ($lecturer->photo) {
                Storage::delete($lecturer->photo);
            }
            $path = $request->file('photo')->store('public/lecturer-photos');
            $validated['photo'] = $path;
        }

        $validated['active'] = $request->has('active');
        $lecturer->update($validated);
        
        return redirect()->route('admin.lecturers.index')->with('success', 'Data Dosen berhasil diperbarui.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        if ($lecturer->photo) {
            Storage::delete($lecturer->photo);
        }
        $lecturer->delete();
        return redirect()->route('admin.lecturers.index')->with('success', 'Data Dosen berhasil dihapus.');
    }
}
