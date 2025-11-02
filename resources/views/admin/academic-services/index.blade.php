@extends('layouts.admin')
@section('title', 'Manajemen Layanan Akademik')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Manajemen Layanan Akademik</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola ikon, judul layanan, dan deskripsi layanan akademik.</p>
            </div>

            <a href="{{ route('admin.academic-services.create') }}"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Layanan</span>
            </a>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Card utama (list) --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
        {{-- Header kolom (desktop) --}}
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
            <div class="col-span-2">Ikon</div>
            <div class="col-span-3">Judul Layanan</div>
            <div class="col-span-5">Deskripsi</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>

        @forelse ($services as $service)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex flex-col md:grid md:grid-cols-12 md:items-center gap-4">
                        {{-- Ikon/Foto --}}
                        <div class="md:col-span-2">
                            <div class="flex items-center md:justify-start">
                                @if($service->image)
                                    <img src="{{ Storage::url($service->image) }}"
                                         alt="{{ $service->title }}"
                                         class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-200">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-red-50 text-red-600 grid place-items-center ring-2 ring-gray-100">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Judul --}}
                        <div class="md:col-span-3">
                            <p class="font-semibold text-gray-900">{{ $service->title }}</p>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="md:col-span-5 text-gray-700">
                            <p class="text-sm leading-relaxed">
                                {{ $service->description }}
                            </p>
                        </div>

                        {{-- Aksi --}}
                        <div class="md:col-span-2">
                            <div class="flex justify-center md:justify-end gap-2">
                                <a href="{{ route('admin.academic-services.edit', $service->id) }}"
                                   class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('admin.academic-services.destroy', $service->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
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

                    {{-- Divider mobile --}}
                    <div class="md:hidden mt-3 h-px bg-gray-100"></div>
                </div>
            </div>
        @empty
            <div class="px-6 py-10 text-center text-gray-500">Belum ada data layanan akademik.</div>
        @endforelse
    </div>
@endsection
