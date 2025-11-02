@extends('layouts.admin')
@section('title', 'Kategori Galeri')

@section('content')
    {{-- HEADER --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Kategori Galeri</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola daftar kategori untuk mengelompokkan galeri.</p>
            </div>

            {{-- Form tambah: tetap pakai route & method asli --}}
            <form action="{{ route('admin.albums.store') }}" method="POST" class="w-full md:w-auto">
                @csrf
                <div class="flex items-center gap-2">
                    <div class="relative flex-1 md:flex-none md:w-80">
                        <input
                            type="text"
                            name="title"
                            placeholder="Nama Kategori Baru"
                            class="w-full rounded-full border border-gray-200 bg-white pl-4 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200"
                            required
                        >
                    </div>
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg shadow-sm">
                        <i class="fa-solid fa-plus"></i>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- LIST ala kartu --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
        {{-- Header kolom (desktop) --}}
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
            <div class="col-span-10">Nama Kategori</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>

        @forelse ($categories as $category)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex flex-col md:grid md:grid-cols-12 md:items-center gap-4">
                        {{-- Nama --}}
                        <div class="md:col-span-10 flex items-start gap-3">
                            <div class="h-9 w-9 rounded-xl bg-indigo-100 grid place-items-center text-indigo-600">
                                <i class="fa-solid fa-folder"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $category->title }}</p>
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="md:col-span-2">
                            <div class="flex md:justify-center">
                                <form action="{{ route('admin.albums.destroy', $category->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 border border-red-200 text-red-600 hover:bg-red-50 font-medium px-3 py-2 rounded-lg">
                                        <i class="fa-regular fa-trash-can"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile separator look --}}
                    <div class="md:hidden mt-3 h-px bg-gray-100"></div>
                </div>
            </div>
        @empty
            <div class="px-6 py-10 text-center text-gray-500">Belum ada kategori.</div>
        @endforelse
    </div>
@endsection
