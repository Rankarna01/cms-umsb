@extends('layouts.admin')
@section('title', 'Upload Foto Baru')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Upload Foto Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Unggah foto ke dalam kategori galeri yang tersedia.</p>
    </div>

    {{-- Alert success/error (jika ada) --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card Form --}}
    <div class="bg-white shadow-sm rounded-2xl p-6 max-w-3xl">
        <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Judul Foto --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Foto (Opsional)</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                       placeholder="Masukkan judul foto">
                @error('title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="album_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="album_id" id="album_id"
                        class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('album_id') == $category->id)>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('album_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- File Foto --}}
            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mb-1">File Foto</label>
                <input type="file" name="image_path" id="image_path"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                       required>
                @error('image_path')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                <p class="text-xs text-gray-500 mt-1">Format yang disarankan: JPG, PNG, maksimal 2MB.</p>
            </div>

            {{-- Tombol aksi --}}
            <div class="pt-3 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm">
                    <i class="fa-solid fa-upload"></i>
                    <span>Upload</span>
                </button>

                <a href="{{ route('admin.photos.index') }}"
                   class="inline-flex items-center gap-2 border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium px-5 py-2.5 rounded-lg">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
@endsection
