<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DocumentCategoryController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::latest()->get();
        return view('admin.document-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.document-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:document_categories,name']);
        $validated['slug'] = Str::slug($validated['name']);
        DocumentCategory::create($validated);
        return redirect()->route('admin.document-categories.index')->with('success', 'Kategori dokumen berhasil ditambahkan.');
    }

    public function edit(DocumentCategory $documentCategory)
    {
        return view('admin.document-categories.edit', compact('documentCategory'));
    }

    public function update(Request $request, DocumentCategory $documentCategory)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255', Rule::unique('document_categories')->ignore($documentCategory->id)]]);
        $validated['slug'] = Str::slug($validated['name']);
        $documentCategory->update($validated);
        return redirect()->route('admin.document-categories.index')->with('success', 'Kategori dokumen berhasil diperbarui.');
    }

    public function destroy(DocumentCategory $documentCategory)
    {
        $documentCategory->delete();
        return redirect()->route('admin.document-categories.index')->with('success', 'Kategori dokumen berhasil dihapus.');
    }
}