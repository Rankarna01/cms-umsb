<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuickLink;
use Illuminate\Http\Request;

class QuickLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quickLinks = QuickLink::orderBy('sort_order')->get();
        return view('admin.quick-links.index', compact('quickLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.quick-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        QuickLink::create($validated);
        return redirect()->route('admin.quick-links.index')->with('success', 'Link Cepat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuickLink $quickLink)
    {
        return view('admin.quick-links.edit', compact('quickLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuickLink $quickLink)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        $quickLink->update($validated);
        return redirect()->route('admin.quick-links.index')->with('success', 'Link Cepat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuickLink $quickLink)
    {
        $quickLink->delete();
        return redirect()->route('admin.quick-links.index')->with('success', 'Link Cepat berhasil dihapus.');
    }
}

