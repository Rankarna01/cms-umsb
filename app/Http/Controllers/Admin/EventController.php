<?php

namespace App\Http\Controllers\Admin; // <-- Ini untuk ADMIN

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Menampilkan daftar semua agenda. (Fungsi Admin)
     */
    public function index()
    {
        $events = Event::with(['author', 'document'])->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan form untuk membuat agenda baru. (Fungsi Admin)
     */
    public function create()
    {
        $documents = Document::orderBy('title')->get();
        return view('admin.events.create', compact('documents'));
    }

    /**
     * Menyimpan agenda baru. (Fungsi Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug',
            'description' => 'nullable|string',
            'tanggal' => 'required|date', // <-- Diubah
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'document_id' => 'nullable|exists:documents,id',
            'active' => 'nullable|boolean',
            // field 'start_date', 'end_date', 'location', 'contact_person' dihapus
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        $validated['author_id'] = auth()->id();
        $validated['active'] = $request->has('active');

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit agenda. (Fungsi Admin)
     */
    public function edit(Event $event)
    {
        $documents = Document::orderBy('title')->get();
        return view('admin.events.edit', compact('event', 'documents'));
    }

    /**
     * Memperbarui agenda di database. (Fungsi Admin)
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('events')->ignore($event->id)],
            'description' => 'nullable|string',
            'tanggal' => 'required|date', // <-- Diubah
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'document_id' => 'nullable|exists:documents,id',
            'active' => 'nullable|boolean',
            // field 'start_date', 'end_date', 'location', 'contact_person' dihapus
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) Storage::delete($event->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        $validated['active'] = $request->has('active');
        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Menghapus agenda. (Fungsi Admin)
     */
    public function destroy(Event $event)
    {
        if ($event->thumbnail) Storage::delete($event->thumbnail);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dihapus.');
    }
}