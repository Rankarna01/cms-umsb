@extends('layouts.admin')
@section('title', 'Manajemen Fakta Kampus')

@section('content')
    {{-- HEADER --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Manajemen Fakta Kampus</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola ikon, label, dan nilai/angka.</p>
            </div>

            <div class="flex items-center gap-3">
                {{-- (Opsional) Search UI, tidak mengubah fungsi --}}
                <form method="GET" action="" class="relative hidden md:block">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari label/nilai..."
                        class="w-80 rounded-full border border-gray-200 bg-white pl-11 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200"
                    >
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                </form>

                <a href="{{ route('admin.factoids.create') }}"
                   class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                    <i class="fa-solid fa-square-plus"></i>
                    <span>Tambah Fakta</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- WRAPPER LIST ala "kartu" --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
        {{-- Header kolom (desktop) --}}
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
            <div class="col-span-2 text-center">Ikon</div>
            <div class="col-span-5">Label</div>
            <div class="col-span-3">Nilai/Angka</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>

        @forelse ($factoids as $factoid)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    {{-- Desktop layout --}}
                    <div class="hidden md:grid md:grid-cols-12 md:items-center gap-4">
                        {{-- Ikon --}}
                        <div class="col-span-2 flex justify-center">
                            <div class="h-10 w-10 rounded-xl bg-indigo-100 grid place-items-center">
                                <i class="{{ $factoid->icon ?? 'fa-solid fa-question-circle' }} text-indigo-600 text-xl"></i>
                            </div>
                        </div>

                        {{-- Label --}}
                        <div class="col-span-5">
                            <p class="font-semibold text-gray-900 leading-snug">
                                {{ $factoid->label }}
                            </p>
                        </div>

                        {{-- Nilai/Angka --}}
                        <div class="col-span-3">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-700">
                                {{ $factoid->value }}
                            </span>
                        </div>

                        {{-- Aksi --}}
                        <div class="col-span-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.factoids.edit', $factoid->id) }}"
                                   class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('admin.factoids.destroy', $factoid->id) }}" method="POST"
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

                    {{-- Mobile layout (card) --}}
                    <div class="md:hidden">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-xl bg-indigo-100 grid place-items-center shrink-0">
                                <i class="{{ $factoid->icon ?? 'fa-solid fa-question-circle' }} text-indigo-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $factoid->label }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    Nilai/Angka:
                                    <span class="font-semibold">{{ $factoid->value }}</span>
                                </p>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <a href="{{ route('admin.factoids.edit', $factoid->id) }}"
                                       class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.factoids.destroy', $factoid->id) }}" method="POST"
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
                    </div>

                </div>
            </div>
        @empty
            <div class="px-6 py-10 text-center text-gray-500">Belum ada data fakta.</div>
        @endforelse
    </div>
@endsection
