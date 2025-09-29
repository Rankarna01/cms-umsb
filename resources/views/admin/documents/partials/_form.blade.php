<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ isset($document) ? route('admin.documents.update', $document->id) : route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($document)) @method('PUT') @endif
        <div class="mb-4">
            <label for="title" class="block font-bold mb-2">Judul Dokumen</label>
            <input type="text" name="title" id="title" value="{{ old('title', $document->title ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label for="document_category_id" class="block font-bold mb-2">Kategori</label>
            <select name="document_category_id" id="document_category_id" class="shadow border rounded w-full py-2 px-3" required>
                <option>-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('document_category_id', $document->document_category_id ?? '') == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="summary" class="block font-bold mb-2">Ringkasan (Opsional)</label>
            <textarea name="summary" id="summary" rows="3" class="shadow border rounded w-full py-2 px-3">{{ old('summary', $document->summary ?? '') }}</textarea>
        </div>
        <div class="mb-4">
            <label for="file" class="block font-bold mb-2">File Dokumen</label>
            @if(isset($document)) <p class="text-sm mb-2">File saat ini: <a href="{{ Storage::url($document->file_path) }}" class="text-blue-500" target="_blank">Lihat</a>. Kosongkan jika tidak ingin mengubah.</p> @endif
            <input type="file" name="file" id="file" class="shadow border rounded w-full py-2 px-3" @if(!isset($document)) required @endif>
        </div>
        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($document) ? 'Perbarui' : 'Upload' }}</button>
            <a href="{{ route('admin.documents.index') }}" class="ml-4">Batal</a>
        </div>
    </form>
</div>