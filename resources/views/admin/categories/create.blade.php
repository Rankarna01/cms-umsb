@extends('layouts.admin')

{{-- Judul halaman akan dinamis, 'Tambah' atau 'Edit' --}}
@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">
    {{-- Judul h1 juga dinamis --}}
    {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
</h1>

<div class="bg-white shadow-md rounded-lg p-8">
    {{-- Form akan mengarah ke route 'store' (untuk simpan baru) atau 'update' (untuk perbarui) --}}
    <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
        @csrf {{-- Wajib untuk keamanan Laravel --}}
        
        {{-- Jika ini adalah form edit, kita butuh method PUT --}}
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $category->name ?? '') }}" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                   required>
            @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-gray-700 text-sm font-bold mb-2">Slug</label>
            <input type="text" name="slug" id="slug" 
                   value="{{ old('slug', $category->slug ?? '') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('slug') border-red-500 @enderror">
            <p class="text-gray-600 text-xs italic mt-1">Kosongkan agar dibuat otomatis dari nama.</p>
            @error('slug')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Tipe</label>
            <select name="type" id="type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                <option value="news" {{ old('type', $category->type ?? 'news') == 'news' ? 'selected' : '' }}>Berita</option>
                <option value="information" {{ old('type', $category->type ?? '') == 'information' ? 'selected' : '' }}>Informasi</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <label class="inline-flex items-center">
                <input type="hidden" name="active" value="0"> {{-- Nilai default jika checkbox tidak dicentang --}}
                <input type="checkbox" name="active" value="1" class="form-checkbox" 
                       {{ old('active', $category->active ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Aktif</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{-- Teks tombol juga dinamis --}}
                {{ isset($category) ? 'Perbarui Kategori' : 'Simpan Kategori' }}
            </button>
            <a href="{{ route('admin.categories.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection