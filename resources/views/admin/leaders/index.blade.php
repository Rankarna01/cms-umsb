@extends('layouts.admin')
@section('title', 'Manajemen Pimpinan')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Manajemen Pimpinan</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola daftar pimpinan, foto, dan jabatan di lingkungan kampus.</p>
            </div>

            <a href="{{ route('admin.leaders.create') }}"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Pimpinan</span>
            </a>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card utama --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
        {{-- Header kolom --}}
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
            <div class="col-span-2 text-center">Foto</div>
            <div class="col-span-4">Nama</div>
            <div class="col-span-4">Jabatan</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>

        @forelse ($leaders as $leader)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex flex-col md:grid md:grid-cols-12 md:items-center gap-4">
                        {{-- Foto --}}
                        <div class="md:col-span-2 flex justify-center">
                            <img src="{{ $leader->photo ? Storage::url($leader->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($leader->name) }}"
                                 alt="{{ $leader->name }}"
                                 class="h-16 w-16 rounded-full object-cover ring-2 ring-gray-200">
                        </div>

                        {{-- Nama --}}
                        <div class="md:col-span-4 text-center md:text-left">
                            <p class="font-semibold text-gray-900">{{ $leader->name }}</p>
                        </div>

                        {{-- Jabatan --}}
                        <div class="md:col-span-4 text-center md:text-left text-gray-700">
                            {{ $leader->position }}
                        </div>

                        {{-- Aksi --}}
                        <div class="md:col-span-2 flex justify-center md:justify-end gap-2">
                            <a href="{{ route('admin.leaders.edit', $leader->id) }}"
                               class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.leaders.destroy', $leader->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus pimpinan ini?');">
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
            </div>
        @empty
            <div class="px-6 py-10 text-center text-gray-500">Belum ada data pimpinan.</div>
        @endforelse
    </div>
@endsection
