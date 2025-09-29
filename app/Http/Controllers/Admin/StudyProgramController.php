<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudyProgramController extends Controller
{
    public function index()
    {
        // Eager load relasi 'faculty' untuk efisiensi query
        $studyPrograms = StudyProgram::with('faculty')->latest()->get();
        return view('admin.study-programs.index', compact('studyPrograms'));
    }

    public function create()
    {
        // Ambil data fakultas untuk ditampilkan di dropdown form
        $faculties = Faculty::where('active', true)->orderBy('name')->get();
        return view('admin.study-programs.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
            'active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($request->name . '-' . $request->faculty_id);
        $validated['active'] = $request->has('active');

        StudyProgram::create($validated);

        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit(StudyProgram $studyProgram)
    {
        $faculties = Faculty::where('active', true)->orderBy('name')->get();
        return view('admin.study-programs.edit', compact('studyProgram', 'faculties'));
    }

    public function update(Request $request, StudyProgram $studyProgram)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
            'active' => 'nullable|boolean',
        ]);
        
        $validated['slug'] = Str::slug($request->name . '-' . $request->faculty_id);
        $validated['active'] = $request->has('active');

        $studyProgram->update($validated);

        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy(StudyProgram $studyProgram)
    {
        $studyProgram->delete();
        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}
