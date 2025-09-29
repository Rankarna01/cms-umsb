<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::orderBy('sort_order')->get();
        return view('admin.leaders.index', compact('leaders'));
    }

    public function create()
    {
        return view('admin.leaders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/leaders');
            $validated['photo'] = $path;
        }

        Leader::create($validated);
        return redirect()->route('admin.leaders.index')->with('success', 'Data Pimpinan berhasil ditambahkan.');
    }

    public function edit(Leader $leader)
    {
        return view('admin.leaders.edit', compact('leader'));
    }

    public function update(Request $request, Leader $leader)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($leader->photo) Storage::delete($leader->photo);
            $path = $request->file('photo')->store('public/leaders');
            $validated['photo'] = $path;
        }
        
        $leader->update($validated);
        return redirect()->route('admin.leaders.index')->with('success', 'Data Pimpinan berhasil diperbarui.');
    }

    public function destroy(Leader $leader)
    {
        if ($leader->photo) Storage::delete($leader->photo);
        $leader->delete();
        return redirect()->route('admin.leaders.index')->with('success', 'Data Pimpinan berhasil dihapus.');
    }
}
