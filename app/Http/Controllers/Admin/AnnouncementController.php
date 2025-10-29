<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Document; // <-- TAMBAHKAN INI
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['category', 'author', 'document'])->latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        
        $documents = Document::orderBy('title')->get(); // Ambil daftar dokumen
        return view('admin.announcements.create', compact('documents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:announcements,slug',
            'content' => 'required|string',
           
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Field baru
            'document_id' => 'nullable|exists:documents,id', // Field baru
            'active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('announcements', 'public');
        }

        $validated['author_id'] = auth()->id();
        $validated['active'] = $request->has('active');
        $validated['published_at'] = now();

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
       
        $documents = Document::orderBy('title')->get(); // Ambil daftar dokumen
        return view('admin.announcements.edit', compact('announcement', 'documents'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('announcements')->ignore($announcement->id)],
            'content' => 'required|string',
           
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Field baru
            'document_id' => 'nullable|exists:documents,id', // Field baru
            'active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            if ($announcement->thumbnail) Storage::delete($announcement->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('announcements', 'public');
        }

        $validated['active'] = $request->has('active');
        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->thumbnail) Storage::delete($announcement->thumbnail);
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
