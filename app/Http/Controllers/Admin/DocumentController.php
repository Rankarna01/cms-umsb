<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['category', 'author'])->latest()->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = DocumentCategory::orderBy('name')->get();
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240', // Maks 10MB
        ]);

        $path = $request->file('file')->store('public/documents');
        
        Document::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'summary' => $validated['summary'],
            'document_category_id' => $validated['document_category_id'],
            'file_path' => $path,
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diupload.');
    }

    public function edit(Document $document)
    {
        $categories = DocumentCategory::orderBy('name')->get();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('file')) {
            Storage::delete($document->file_path);
            $path = $request->file('file')->store('public/documents');
            $validated['file_path'] = $path;
        }

        $document->update($validated);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}