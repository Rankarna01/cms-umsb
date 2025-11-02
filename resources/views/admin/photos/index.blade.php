@extends('layouts.admin')
@section('title', 'Galeri Foto')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Galeri Foto</h1>
                <p class="text-sm text-gray-500 mt-1">Koleksi foto yang telah diunggah ke sistem galeri.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.photos.create') }}"
                   class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                    <i class="fa-solid fa-upload"></i>
                    <span>Upload Foto</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card utama --}}
    <div class="bg-white shadow-sm rounded-2xl p-6">
        @if($photos->isEmpty())
            <div class="text-center text-gray-500 py-10">
                Belum ada foto.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
                @foreach($photos as $photo)
                    <div class="relative group overflow-hidden rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200">
                        {{-- Gambar --}}
                        <img src="{{ Storage::url($photo->image_path) }}"
                             alt="{{ $photo->title ?? 'Foto' }}"
                             class="w-full h-40 object-cover transition-transform duration-300 group-hover:scale-105">

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-center">
                            {{-- Judul foto jika ada --}}
                            @if($photo->title)
                                <p class="text-white text-sm font-semibold mb-2 px-2 truncate w-11/12">{{ $photo->title }}</p>
                            @endif

                            <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm">
                                    <i class="fa-regular fa-trash-can"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
