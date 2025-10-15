@extends('layouts.admin')
@section('title', 'Upload Foto Baru')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Upload Foto Baru</h1>
    <div class="bg-white shadow-md rounded-lg p-8 max-w-2xl">
        {{-- ... (bagian error) ... --}}
        <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- INPUT UNTUK JUDUL --}}
            <div class="mb-4">
                <label for="title" class="block font-bold mb-2">Judul Foto (Opsional)</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="album_id" class="block font-bold mb-2">Kategori</label>
                <select name="album_id" id="album_id" class="shadow border rounded w-full py-2 px-3" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="image_path" class="block font-bold mb-2">File Foto</label>
                <input type="file" name="image_path" id="image_path" class="shadow border rounded w-full py-2 px-3" required>
            </div>
            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Upload</button>
                <a href="{{ route('admin.photos.index') }}" class="ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection