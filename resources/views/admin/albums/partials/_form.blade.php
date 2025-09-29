<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($album) ? route('admin.albums.update', $album->id) : route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($album))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Album</label>
            <input type="text" name="title" id="title" value="{{ old('title', $album->title ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('description', $album->description ?? '') }}</textarea>
        </div>

        <div class="mb-6">
            <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Sampul (Opsional)</label>
            @if(isset($album) && $album->cover_image)
                <img src="{{ Storage::url($album->cover_image) }}" alt="Current cover" class="w-1/3 rounded mb-2">
            @endif
            <input type="file" name="cover_image" id="cover_image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
        </div>

        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ isset($album) ? 'Perbarui Album' : 'Simpan Album' }}
            </button>
            <a href="{{ route('admin.albums.index') }}" class="ml-4 text-gray-600">Batal</a>
        </div>
    </form>
</div>