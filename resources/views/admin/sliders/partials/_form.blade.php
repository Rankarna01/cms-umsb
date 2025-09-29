<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($slide) ? route('admin.sliders.update', $slide)
                                   : route('admin.sliders.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @isset($slide) @method('PUT') @endisset

        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $slide->title ?? '') }}"
                   class="shadow border rounded w-full py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label for="caption" class="block text-gray-700 text-sm font-bold mb-2">Caption</label>
            <input type="text" name="caption" id="caption"
                   value="{{ old('caption', $slide->caption ?? '') }}"
                   class="shadow border rounded w-full py-2 px-3">
        </div>

        <div class="mb-4">
            <label for="link_url" class="block text-gray-700 text-sm font-bold mb-2">URL Link</label>
            <input type="url" name="link_url" id="link_url"
                   value="{{ old('link_url', $slide->link_url ?? '') }}"
                   placeholder="https://contoh.com"
                   class="shadow border rounded w-full py-2 px-3">
        </div>

        <div class="mb-4">
            <label for="button_text" class="block text-gray-700 text-sm font-bold mb-2">Teks Tombol</label>
            <input type="text" name="button_text" id="button_text"
                   value="{{ old('button_text', $slide->button_text ?? '') }}"
                   class="shadow border rounded w-full py-2 px-3">
        </div>

        <div class="mb-4">
            <label for="sort_order" class="block text-gray-700 text-sm font-bold mb-2">Urutan</label>
            <input type="number" name="sort_order" id="sort_order" min="0"
                   value="{{ old('sort_order', $slide->sort_order ?? 0) }}"
                   class="shadow border rounded w-40 py-2 px-3">
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Slide</label>
            @if(isset($slide) && $slide->image)
                <img src="{{ Storage::url($slide->image) }}" alt="Current image" class="w-1/2 rounded mb-2">
            @endif
            <input type="file" name="image" id="image"
                   class="shadow border rounded w-full py-2 px-3"
                   @if(!isset($slide)) required @endif>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <label class="inline-flex items-center">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1"
                       class="form-checkbox"
                       {{ old('active', $slide->active ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Aktifkan slide ini</span>
            </label>
        </div>

        <div class="flex items-center">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ isset($slide) ? 'Perbarui Slide' : 'Simpan Slide' }}
            </button>
            <a href="{{ route('admin.sliders.index') }}"
               class="ml-4 inline-block font-bold text-sm text-gray-600 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
