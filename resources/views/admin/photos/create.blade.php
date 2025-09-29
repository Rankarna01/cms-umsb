@extends('layouts.admin')
@section('title', 'Upload Foto ke Album')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Upload Foto ke: <span class="text-blue-600">{{ $album->title }}</span></h1>
    <div class="bg-white shadow-md rounded-lg p-8">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('photos.store', $album->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="photos" class="block font-bold mb-2">Pilih Foto (bisa lebih dari satu)</label>
                <input type="file" name="photos[]" id="photos" class="shadow border rounded w-full py-2 px-3" required multiple>
                <p class="text-xs text-gray-600 mt-1">Tahan Ctrl (atau Cmd di Mac) untuk memilih beberapa file.</p>
            </div>
            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Upload</button>
                <a href="{{ route('admin.albums.show', $album->id) }}" class="ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection