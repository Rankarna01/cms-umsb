@extends('layouts.admin')
@section('title', 'Album: ' . $album->title)
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Album: <span class="text-blue-600">{{ $album->title }}</span></h1>
        <a href="{{ route('photos.create', $album->id) }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded">+ Upload Foto</a>
    </div>
    @if(session('success'))<div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>@endif
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @forelse($photos as $photo)
            <div class="relative group">
                <img src="{{ Storage::url($photo->image_path) }}" class="w-full h-40 object-cover rounded-lg shadow-md">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Yakin?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-white bg-red-600 px-3 py-1 rounded">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">Belum ada foto di album ini.</p>
        @endforelse
    </div>
@endsection