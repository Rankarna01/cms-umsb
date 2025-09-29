<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'video_url' => 'required|url',
        ]);

        $validated['author_id'] = auth()->id();

        Video::create($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'video_url' => 'required|url',
        ]);

        $video->update($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }
}