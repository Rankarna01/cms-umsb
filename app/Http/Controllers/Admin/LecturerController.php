<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with(['faculty', 'studyProgram'])->latest()->get();
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $faculties = Faculty::where('active', true)->orderBy('name')->get();
        $studyPrograms = StudyProgram::where('active', true)->orderBy('name')->get();
        return view('admin.lecturers.create', compact('faculties', 'studyPrograms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nidn' => 'nullable|string|max:255|unique:lecturers,nidn',
            'position' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:lecturers,email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'faculty_id' => 'nullable|exists:faculties,id',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'expertise' => 'nullable|string',
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

    public function edit(Lecturer $lecturer)
    {
        $faculties = Faculty::where('active', true)->orderBy('name')->get();
        $studyPrograms = StudyProgram::where('active', true)->orderBy('name')->get();
        return view('admin.lecturers.edit', compact('lecturer', 'faculties', 'studyPrograms'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nidn' => 'nullable|string|max:255|unique:lecturers,nidn,' . $lecturer->id,
            'position' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:lecturers,email,' . $lecturer->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'faculty_id' => 'nullable|exists:faculties,id',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'expertise' => 'nullable|string',
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

    public function destroy(Lecturer $lecturer)
    {
        if ($lecturer->photo) {
            Storage::delete($lecturer->photo);
        }
        $lecturer->delete();
        return redirect()->route('admin.lecturers.index')->with('success', 'Data Dosen berhasil dihapus.');
    }
}