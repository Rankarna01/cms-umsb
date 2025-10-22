<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcademicServiceController extends Controller
{
    public function index()
    {
        $services = AcademicService::orderBy('sort_order')->get();
        return view('admin.academic-services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.academic-services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:1024',
            'url' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('academic_services', 'public');
        }

        AcademicService::create($validated);
        return redirect()->route('admin.academic-services.index')->with('success', 'Layanan Akademik berhasil ditambahkan.');
    }

    public function edit(AcademicService $academicService)
    {
        return view('admin.academic-services.edit', compact('academicService'));
    }

    public function update(Request $request, AcademicService $academicService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:1024',
            'url' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($academicService->image) Storage::delete($academicService->image);
            $validated['image'] = $request->file('image')->store('academic_services', 'public');
        }

        $academicService->update($validated);
        return redirect()->route('admin.academic-services.index')->with('success', 'Layanan Akademik berhasil diperbarui.');
    }

    public function destroy(AcademicService $academicService)
    {
        if ($academicService->image) Storage::delete($academicService->image);
        $academicService->delete();
        return redirect()->route('admin.academic-services.index')->with('success', 'Layanan Akademik berhasil dihapus.');
    }
}