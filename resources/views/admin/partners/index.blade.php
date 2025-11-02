@extends('layouts.admin')
@section('title', 'Kerja Sama & Media')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Kerja Sama & Media</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Daftar mitra kerja sama dan media partner universitas.
                </p>
            </div>

            <a href="{{ route('admin.partners.create') }}"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                <i class="fa-solid fa-handshake"></i>
                <span>Tambah Partner</span>
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
            <div class="col-span-3 text-center">Logo</div>
            <div class="col-span-4">Nama Instansi / Media</div>
            <div class="col-span-3">Tipe</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>

        @forelse ($partners as $partner)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex flex-col md:grid md:grid-cols-12 md:items-center gap-4">
                        {{-- Logo --}}
                        <div class="md:col-span-3 flex justify-center">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center p-2 w-32 h-16">
                                <img src="{{ $partner->logo ? Storage::url($partner->logo) : 'https://via.placeholder.com/150x50' }}"
                                     alt="{{ $partner->name }}"
                                     class="max-h-12 object-contain">
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="md:col-span-4 text-center md:text-left">
                            <p class="font-semibold text-gray-900">{{ $partner->name }}</p>
                        </div>

                        {{-- Tipe --}}
                        <div class="md:col-span-3 text-center md:text-left capitalize text-gray-700">
                            {{ $partner->type }}
                        </div>

                        {{-- Aksi --}}
                        <div class="md:col-span-2 flex justify-center md:justify-end gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}"
                               class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus partner ini?');">
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
            <div class="px-6 py-10 text-center text-gray-500">Belum ada data partner.</div>
        @endforelse
    </div>
@endsection
