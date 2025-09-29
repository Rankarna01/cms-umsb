<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factoid;
use Illuminate\Http\Request;

class FactoidController extends Controller
{
    public function index()
    {
        $factoids = Factoid::orderBy('sort_order')->get();
        return view('admin.factoids.index', compact('factoids'));
    }

    public function create()
    {
        return view('admin.factoids.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        Factoid::create($validated);
        return redirect()->route('admin.factoids.index')->with('success', 'Fakta berhasil ditambahkan.');
    }

    public function edit(Factoid $factoid)
    {
        return view('admin.factoids.edit', compact('factoid'));
    }

    public function update(Request $request, Factoid $factoid)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        $factoid->update($validated);
        return redirect()->route('admin.factoids.index')->with('success', 'Fakta berhasil diperbarui.');
    }

    public function destroy(Factoid $factoid)
    {
        $factoid->delete();
        return redirect()->route('admin.factoids.index')->with('success', 'Fakta berhasil dihapus.');
    }
}