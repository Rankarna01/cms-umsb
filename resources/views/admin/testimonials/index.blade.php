@extends('layouts.admin')
@section('title', 'Manajemen Testimoni')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Manajemen Testimoni</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola testimoni alumni yang akan ditampilkan di halaman utama.</p>
            </div>

            <a href="{{ route('admin.testimonials.create') }}"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                <i class="fa-solid fa-comment-dots"></i>
                <span>Tambah Testimoni</span>
            </a>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card utama --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
        {{-- Header kolom --}}
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
            <div class="col-span-4">Alumni</div>
            <div class="col-span-4">Testimoni</div>
            <div class="col-span-2 text-center">Status</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>

        @forelse ($testimonials as $testimonial)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex flex-col md:grid md:grid-cols-12 md:items-center gap-4">

                        {{-- Alumni --}}
                        <div class="md:col-span-4 flex items-center gap-4">
                            <img class="h-14 w-14 rounded-full object-cover ring-2 ring-gray-200 flex-shrink-0"
                                 src="{{ $testimonial->photo ? Storage::url($testimonial->photo) : 'https://ui-avatars.com/api/?name='.urlencode($testimonial->name) }}"
                                 alt="{{ $testimonial->name }}">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $testimonial->name }}</p>
                                <p class="text-xs text-gray-600">
                                    {{ $testimonial->occupation ?? 'Angkatan ' . $testimonial->graduation_year }}
                                </p>
                            </div>
                        </div>

                        {{-- Testimoni --}}
                        <div class="md:col-span-4 text-gray-700 italic">
                            “{{ Str::limit($testimonial->content, 100) }}”
                        </div>

                        {{-- Status --}}
                        <div class="md:col-span-2 text-center">
                            @if($testimonial->active)
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Non-Aktif</span>
                            @endif
                        </div>

                        {{-- Aksi --}}
                        <div class="md:col-span-2 flex justify-center md:justify-end gap-2">
                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                               class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus testimoni ini?');">
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
            <div class="px-6 py-10 text-center text-gray-500">Belum ada data testimoni.</div>
        @endforelse
    </div>
@endsection
