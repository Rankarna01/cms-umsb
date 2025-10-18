<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kerjasama,media',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners', 'public');
            $validated['logo'] = $path;
        }

        Partner::create($validated);
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kerjasama,media',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo) Storage::delete($partner->logo);
            $path = $request->file('logo')->store('partners', 'public');
            $validated['logo'] = $path;
        }
        
        $partner->update($validated);
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) Storage::delete($partner->logo);
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus.');
    }
}

