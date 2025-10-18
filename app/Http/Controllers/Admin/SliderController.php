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
        $sliders = Slide::with(['images'])
            ->where('active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'caption'     => 'nullable|string|max:1000',
            'layout'      => 'required|in:full_width,split',
            'images'      => 'required|array|min:1',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            'link_url'    => 'nullable|url',
            'button_text' => 'nullable|string|max:50',
            'sort_order'  => 'nullable|integer',
            'active'      => 'nullable|boolean',
        ]);

        $validated['active'] = $request->boolean('active');

        $slide = Slide::create($validated);

        // simpan semua gambar
        $order = 1;
        foreach ($request->file('images') as $file) {
            $path = $file->store('public/sliders');
            $slide->images()->create([
                'image_path' => $path,
                'sort_order' => $order++,
            ]);
        }

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil dibuat.');
    }

    public function edit(Slide $slider)
    {
        $slider->load('images');
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slide $slider)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'caption'     => 'nullable|string|max:1000',
            'layout'      => 'required|in:full_width,split',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            'link_url'    => 'nullable|url',
            'button_text' => 'nullable|string|max:50',
            'sort_order'  => 'nullable|integer',
            'active'      => 'nullable|boolean',
        ]);

        $validated['active'] = $request->boolean('active');

        $slider->update($validated);

        if ($request->hasFile('images')) {
            $order = (int)($slider->images()->max('sort_order') ?? 0) + 1;
            foreach ($request->file('images') as $file) {
            $path = $file->store('sliders', 'public');
                $slider->images()->create([
                    'image_path' => $path,
                    'sort_order' => $order++,
                ]);
            }
        }

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(Slide $slider)
    {
        $slider->load('images');

        foreach ($slider->images as $image) {
            Storage::delete($image->image_path);
        }
        $slider->images()->delete();
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil dihapus.');
    }
}
