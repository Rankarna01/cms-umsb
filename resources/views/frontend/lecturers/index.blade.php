@extends('layouts.frontend')
@section('title', 'Direktori Dosen')

@section('content')
    {{-- HEADER HALAMAN --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-red-800 to-red-600 text-white">
        <div class="absolute inset-0 opacity-10">
            <div class="h-full w-full bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        </div>
        <div class="container mx-auto px-6 py-14 lg:py-16 relative">
            <nav class="mb-3 text-sm text-red-100/90 flex items-center gap-2">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 hover:text-white transition-colors">
                    <i class="fa-solid fa-house"></i>
                    <span>Home</span>
                </a>
                <i class="fa-solid fa-chevron-right text-red-200/70 text-xs"></i>
                <span class="line-clamp-1">Dosen</span>
            </nav>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight drop-shadow-sm">Direktori Dosen</h1>
            <p class="mt-3 text-red-100/90 max-w-2xl">Jelajahi daftar dosen berdasarkan fakultas dan program studi.</p>
        </div>
    </header>

    <main class="container mx-auto px-6 py-10 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
            {{-- SIDEBAR KIRI: DAFTAR FAKULTAS --}}
            <aside class="lg:col-span-3">
                <div class="sticky top-24 bg-white/90 backdrop-blur rounded-2xl border border-red-100 shadow-sm p-5">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-red-100 flex items-center gap-2">
                        <i class="fa-solid fa-building-columns text-red-600"></i>
                        <span>Fakultas</span>
                    </h3>
                    <ul class="space-y-1.5" role="list">
                        @foreach($faculties as $faculty)
                            <li>
                                <a href="#fakultas-{{ $faculty->slug }}" class="group flex items-center justify-between gap-2 rounded-lg px-3 py-2 text-gray-700 hover:text-red-700 hover:bg-red-50/80 transition ring-1 ring-transparent hover:ring-red-100">
                                    <span class="font-medium">{{ $faculty->name }}</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600">{{ $faculty->lecturers->count() }} dosen</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- KONTEN TENGAH: DAFTAR DOSEN PER FAKULTAS --}}
            <div class="lg:col-span-9">
                @if($faculties->isEmpty())
                    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-gray-500">Belum ada data dosen yang tersedia.</p>
                    </div>
                @else
                    <div class="space-y-16">
                        @foreach($faculties as $faculty)
                            <section id="fakultas-{{ $faculty->slug }}" x-data="{ selectedProdi: 'all' }" class="scroll-mt-28">
                                {{-- Header Section Fakultas dengan Dropdown Filter --}}
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b-2 border-red-600 pb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-red-100 text-red-700 grid place-content-center">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </div>
                                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $faculty->name }}</h2>
                                    </div>
                                    @if($faculty->studyPrograms->isNotEmpty())
                                        <label class="sm:ml-auto inline-flex items-center gap-3">
                                            <span class="text-sm text-gray-600">Filter:</span>
                                            <select x-model="selectedProdi" class="rounded-lg border-gray-300 bg-white shadow-sm focus:border-red-400 focus:ring focus:ring-red-200 focus:ring-opacity-50 text-sm">
                                                <option value="all">Semua Program Studi</option>
                                                @foreach($faculty->studyPrograms as $prodi)
                                                    <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    @endif
                                </div>

                                {{-- Grid Dosen --}}
                                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                                    @foreach($faculty->lecturers as $lecturer)
                                        <div x-show="selectedProdi == 'all' || selectedProdi == '{{ $lecturer->study_program_id }}'" x-transition.opacity>
                                            <div class="group h-full bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col transition duration-300 hover:-translate-y-1.5 hover:shadow-lg focus-within:ring-2 focus-within:ring-red-400">
                                                {{-- Bagian atas yang bisa diklik --}}
                                                <a href="{{ route('lecturers.show', $lecturer->nidn) }}" class="flex-1">
                                                    <div class="relative w-28 h-28 sm:w-32 sm:h-32 mx-auto mb-4">
                                                        <img src="{{ $lecturer->photo ? Storage::url($lecturer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lecturer->name) . '&size=128' }}" alt="{{ $lecturer->name }}" class="w-full h-full rounded-full object-cover ring-4 ring-red-50"/>
                                                        <span class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/50"></span>
                                                    </div>
                                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-700 transition">{{ $lecturer->name }}</h3>
                                                    <p class="text-sm text-red-600 font-medium">{{ $lecturer->functional_position ?? $lecturer->position }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $lecturer->studyProgram->name ?? '' }}</p>
                                                </a>

                                                {{-- Ikon Link Eksternal (di dalam grid kartu) --}}
                                                <div class="mt-5 pt-4 border-t border-gray-100 grid grid-cols-3 place-items-center text-gray-400">
                                                    @if($lecturer->link_pddikti)
                                                        <a href="{{ $lecturer->link_pddikti }}" target="_blank" class="hover:text-red-500 transition" title="Profil PDDIKTI" aria-label="PDDIKTI">
                                                            <i class="fa-solid fa-graduation-cap text-lg"></i>
                                                        </a>
                                                    @else
                                                        <span class="opacity-30"><i class="fa-solid fa-graduation-cap text-lg"></i></span>
                                                    @endif
                                                    @if($lecturer->link_sinta)
                                                        <a href="{{ $lecturer->link_sinta }}" target="_blank" class="hover:text-red-500 transition" title="Profil SINTA" aria-label="SINTA">
                                                            <i class="fa-solid fa-book-open text-lg"></i>
                                                        </a>
                                                    @else
                                                        <span class="opacity-30"><i class="fa-solid fa-book-open text-lg"></i></span>
                                                    @endif
                                                    @if($lecturer->link_scholar)
                                                        <a href="{{ $lecturer->link_scholar }}" target="_blank" class="hover:text-red-500 transition" title="Profil Google Scholar" aria-label="Google Scholar">
                                                            <i class="fa-brands fa-google-scholar text-lg"></i>
                                                        </a>
                                                    @else
                                                        <span class="opacity-30"><i class="fa-brands fa-google-scholar text-lg"></i></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
