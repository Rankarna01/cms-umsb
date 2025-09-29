<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('slides'));
    }

    public function create()
    {
        // form create pakai partial yang sama; variabel $slide TIDAK dikirim
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'caption'     => 'nullable|string|max:255',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url'    => 'nullable|url',
            'button_text' => 'nullable|string|max:50',
            'sort_order'  => 'nullable|integer',
            'active'      => 'nullable|boolean',
        ]);

        $validated['image'] = $request->file('image')->store('public/sliders');
        $validated['active'] = $request->boolean('active');

        Slide::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(Slide $slide)
    {
        // kirim $slide ke view
        return view('admin.sliders.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'caption'     => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url'    => 'nullable|url',
            'button_text' => 'nullable|string|max:50',
            'sort_order'  => 'nullable|integer',
            'active'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama bila ada
            if ($slide->image) {
                Storage::delete($slide->image);
            }
            $validated['image'] = $request->file('image')->store('public/sliders');
        }

        $validated['active'] = $request->boolean('active');

        $slide->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(Slide $slide)
    {
        if ($slide->image) {
            Storage::delete($slide->image);
        }
        $slide->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil dihapus.');
    }
}
