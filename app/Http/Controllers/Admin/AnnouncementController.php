<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['category', 'author'])->latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        // Ambil kategori yang tipenya 'information' saja
        $categories = PostCategory::where('type', 'information')->orderBy('name')->get();
        return view('admin.announcements.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:announcements,slug',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:post_categories,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120', // maks 5MB
            'active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('public/attachments');
            $validated['attachment'] = $path;
        }

        $validated['author_id'] = auth()->id();
        $validated['active'] = $request->has('active');
        $validated['published_at'] = now();

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        $categories = PostCategory::where('type', 'information')->orderBy('name')->get();
        return view('admin.announcements.edit', compact('announcement', 'categories'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('announcements')->ignore($announcement->id)],
            'content' => 'required|string',
            'category_id' => 'nullable|exists:post_categories,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('attachment')) {
            Storage::delete($announcement->attachment);
            $path = $request->file('attachment')->store('public/attachments');
            $validated['attachment'] = $path;
        }

        $validated['active'] = $request->has('active');
        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        Storage::delete($announcement->attachment);
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
