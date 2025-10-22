<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM UTAMA: create / update slider --}}
    <form action="{{ isset($slider) ? route('admin.sliders.update', ['slider' => $slider->id]) : route('admin.sliders.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($slider))
            @method('PUT')
        @endif

        {{-- Tipe Layout --}}
        <div class="mb-4">
            <label for="layout" class="block font-bold mb-2">Tipe Layout</label>
            <select name="layout" id="layout" class="shadow border rounded w-full py-2 px-3">
                <option value="full_width" {{ old('layout', $slider->layout ?? '') === 'full_width' ? 'selected' : '' }}>
                    Full Width (Gambar Penuh)
                </option>
                <option value="split" {{ old('layout', $slider->layout ?? '') === 'split' ? 'selected' : '' }}>
                    Split (Teks Kiri, Gambar Kanan)
                </option>
            </select>
        </div>

        {{-- Judul --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $slider->title ?? '') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   required>
        </div>

        {{-- Caption --}}
        <div class="mb-4">
            <label for="caption" class="block text-gray-700 text-sm font-bold mb-2">Caption (Teks Tambahan)</label>
            <input type="text" name="caption" id="caption"
                   value="{{ old('caption', $slider->caption ?? '') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        {{-- Link & Button --}}
        <div class="mb-4">
            <label for="link_url" class="block text-gray-700 text-sm font-bold mb-2">URL Link (Opsional)</label>
            <input type="url" name="link_url" id="link_url"
                   value="{{ old('link_url', $slider->link_url ?? '') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   placeholder="https://contoh.com">
        </div>

        <div class="mb-4">
            <label for="button_text" class="block text-gray-700 text-sm font-bold mb-2">Teks Tombol (Opsional)</label>
            <input type="text" name="button_text" id="button_text"
                   value="{{ old('button_text', $slider->button_text ?? '') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   placeholder="Selengkapnya">
        </div>

        {{-- Upload Banyak Gambar --}}
        <div class="mb-4">
            <label for="images" class="block font-bold mb-2">Gambar-gambar Slide</label>
            <input type="file" name="images[]" id="images"
                   class="shadow border rounded w-full py-2 px-3"
                   multiple
                   @if(!isset($slider)) required @endif>
            <p class="text-xs text-gray-600 mt-1">
                Anda bisa memilih lebih dari satu gambar.
                @if(isset($slider)) Kosongkan jika tidak ingin menambah gambar baru.@endif
            </p>
        </div>

        {{-- Preview + tombol hapus per gambar (hanya saat edit) --}}
        @if(isset($slider) && ($slider->relationLoaded('images') ? $slider->images->isNotEmpty() : ($slider->images ?? collect())->isNotEmpty()))
            <div class="mb-6">
                <p class="block font-bold mb-2">Gambar Saat Ini:</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($slider->images as $image)
                        <div class="relative group">
                            <img src="{{ Storage::url($image->image_path) }}"
                                 alt="slide-{{ $image->id }}"
                                 class="w-full h-24 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                {{-- TOMBOL HAPUS: submit ke FORM TERPISAH lewat atribut form --}}
                                <button
                                    type="submit"
                                    form="delete-image-{{ $image->id }}"
                                    onclick="return confirm('Yakin ingin menghapus gambar ini?')"
                                    class="text-white text-xs bg-red-600 px-3 py-1.5 rounded-md font-semibold">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                </button>
                            </div>
                            <div class="absolute bottom-1 left-1 bg-white/90 text-xs px-2 py-0.5 rounded">
                                #{{ $image->sort_order }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Urutan tampil --}}
        <div class="mb-4">
            <label for="sort_order" class="block text-gray-700 text-sm font-bold mb-2">Urutan Tampil</label>
            <input type="number" name="sort_order" id="sort_order"
                   value="{{ old('sort_order', $slider->sort_order ?? '0') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold">Status</label>
            <label class="inline-flex items-center mt-2">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1"
                       class="form-checkbox h-5 w-5 text-red-600"
                       {{ old('active', $slider->active ?? true) ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Aktifkan slide ini</span>
            </label>
        </div>

        {{-- Tombol --}}
        <div class="flex items-center">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ isset($slider) ? 'Perbarui Slide' : 'Simpan Slide' }}
            </button>
            <a href="{{ route('admin.sliders.index') }}"
               class="ml-4 inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>

    {{-- =========================
         FORM HAPUS TERPISAH
         ========================= --}}
    @isset($slider)
        @foreach($slider->images as $image)
            <form id="delete-image-{{ $image->id }}"
                  action="{{ route('admin.slide-images.destroy', $image->id) }}"
                  method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endisset
</div>
