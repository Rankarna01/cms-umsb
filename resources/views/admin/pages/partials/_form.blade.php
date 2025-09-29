{{-- Ganti seluruh isi file _form.blade.php dengan ini --}}
<div class="bg-white shadow-md rounded-lg p-8">
    {{-- ... (bagian @if errors) ... --}}
    <form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($page)) @method('PUT') @endif
        <div class="mb-4">
            <label for="title" class="block font-bold mb-2">Judul Halaman</label>
            <input type="text" name="title" id="title" value="{{ old('title', $page->title ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        {{-- FIELD BARU --}}
        <div class="mb-4">
            <label for="summary" class="block font-bold mb-2">Ringkasan (Opsional)</label>
            <textarea name="summary" id="summary" rows="3" class="shadow border rounded w-full py-2 px-3">{{ old('summary', $page->summary ?? '') }}</textarea>
        </div>
        <div class="mb-4">
            <label for="content" class="block font-bold mb-2">Konten</label>
            <textarea name="content" id="content" rows="15" class="shadow border rounded w-full py-2 px-3" required>{{ old('content', $page->content ?? '') }}</textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label for="header_image" class="block font-bold mb-2">Gambar Header (Opsional)</label>
                @if(isset($page) && $page->header_image) <img src="{{ Storage::url($page->header_image) }}" class="w-1/2 rounded mb-2"> @endif
                <input type="file" name="header_image" id="header_image" class="shadow border rounded w-full py-2 px-3">
            </div>
            <div>
                <label for="published_date" class="block font-bold mb-2">Tanggal Publikasi (Opsional)</label>
                <input type="date" name="published_date" id="published_date" value="{{ old('published_date', $page->published_date ?? '') }}" class="shadow border rounded w-full py-2 px-3">
            </div>
        </div>
        {{-- /FIELD BARU --}}
        <div class="mb-6"><label class="inline-flex items-center"><input type="hidden" name="active" value="0"><input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $page->active ?? true) ? 'checked' : '' }}><span class="ml-2">Aktifkan halaman ini</span></label></div>
        <div class="flex items-center"><button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($page) ? 'Perbarui' : 'Simpan' }}</button><a href="{{ route('admin.pages.index') }}" class="ml-4">Batal</a></div>
    </form>
</div>