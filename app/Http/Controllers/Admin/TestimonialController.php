<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'graduation_year' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:1024',
            'content' => 'required|string',
            'active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        $validated['active'] = $request->has('active');

        Testimonial::create($validated);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'graduation_year' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:1024',
            'content' => 'required|string',
            'active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($testimonial->photo) Storage::delete($testimonial->photo);
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        $validated['active'] = $request->has('active');

        $testimonial->update($validated);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo) Storage::delete($testimonial->photo);
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}

