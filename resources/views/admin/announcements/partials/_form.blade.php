<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($announcement) ? route('admin.announcements.update', $announcement->id) : route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($announcement))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Pengumuman</label>
            <input type="text" name="title" id="title" value="{{ old('title', $announcement->title ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori (Opsional)</label>
            <select name="category_id" id="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $announcement->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Isi Pengumuman</label>
            <textarea name="content" id="content" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>{{ old('content', $announcement->content ?? '') }}</textarea>
        </div>
        
        <div class="mb-4">
            <label for="attachment" class="block text-gray-700 text-sm font-bold mb-2">Lampiran (Opsional)</label>
            @if(isset($announcement) && $announcement->attachment)
                <p class="text-sm text-gray-600 mb-2">File saat ini: <a href="{{ Storage::url($announcement->attachment) }}" class="text-blue-500" target="_blank">Lihat File</a></p>
            @endif
            <input type="file" name="attachment" id="attachment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            <p class="text-gray-600 text-xs italic mt-1">Tipe file: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maks 5MB.</p>
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $announcement->active ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Aktifkan pengumuman ini</span>
            </label>
        </div>

        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ isset($announcement) ? 'Perbarui' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="ml-4 text-gray-600">Batal</a>
        </div>
    </form>
</div>