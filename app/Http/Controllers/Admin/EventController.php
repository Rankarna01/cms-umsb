<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('author')->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'contact_person' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('public/posters');
            $validated['poster'] = $path;
        }

        $validated['author_id'] = auth()->id();
        $validated['active'] = $request->has('active');

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('events')->ignore($event->id)],
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'contact_person' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('poster')) {
            Storage::delete($event->poster);
            $path = $request->file('poster')->store('public/posters');
            $validated['poster'] = $path;
        }

        $validated['active'] = $request->has('active');
        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Event $event)
{
    // Cek dulu jika ada file poster sebelum mencoba menghapus
    if ($event->poster) {
        Storage::delete($event->poster);
    }

    // Lanjutkan menghapus data dari database
    $event->delete();

    return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dihapus.');
}
}