<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::latest()->get();
        return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:faculties,name',
            'active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['active'] = $request->has('active');

        Faculty::create($validated);

        return redirect()->route('admin.faculties.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('faculties')->ignore($faculty->id)],
            'active' => 'nullable|boolean',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $validated['active'] = $request->has('active');

        $faculty->update($validated);

        return redirect()->route('admin.faculties.index')->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('admin.faculties.index')->with('success', 'Fakultas berhasil dihapus.');
    }
}