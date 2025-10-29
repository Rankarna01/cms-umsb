@extends('layouts.frontend') {{-- <-- PERBAIKAN NAMA LAYOUT --}}

@section('title', $announcement->title)

@section('content')
    {{-- ===========================
        HERO / HEADER
    ============================ --}}
    @if ($announcement->thumbnail)
        <section class="relative w-full h-[42vh] md:h-[48vh] overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ Storage::url($announcement->thumbnail) }}" alt="{{ $announcement->title }}"
                    class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/20 to-transparent"></div>

            <div class="relative h-full container mx-auto px-6 md:px-10 lg:px-16 flex items-end pb-10">
                <div class="w-full">
                    <nav class="mb-2 text-sm text-white/70">
                        <a href="{{ url('/') }}" class="hover:text-white">Home</a>
                        <span class="mx-2">/</span>
                        <a href="#" class="hover:text-white">Pengumuman</a> {{-- Link ke index jika ada --}}
                        <span class="mx-2">/</span>
                        <span class="line-clamp-1">{{ $announcement->title }}</span>
                    </nav>
                    <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-white">
                        {{ $announcement->title }}
                    </h1>
                </div>
            </div>
        </section>
    @else
        <header class="relative bg-gradient-to-br from-red-800 to-red-800 text-white">
            <div class="container mx-auto px-6 md:px-10 lg:px-16 py-12 md:py-16">
                <nav class="mb-3 text-sm text-white/80">
                    <a href="{{ url('/') }}" class="hover:text-white">Home</a>
                    <span class="mx-2">/</span>
                    <a href="#" class="hover:text-white">Pengumuman</a>
                    <span class="mx-2">/</span>
                    <span class="line-clamp-1">{{ $announcement->title }}</span>
                </nav>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">{{ $announcement->title }}</h1>
            </div>
        </header>
    @endif

    {{-- ===========================
        MAIN CONTENT + SIDEBAR
    ============================ --}}
    <main class="relative z-10">
        <div class="container mx-auto px-6 md:px-10 lg:px-16 py-10 md:py-14
            @if($announcement->thumbnail) -mt-10 md:-mt-14 @endif">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

                {{-- ARTICLE --}}
                <article class="lg:col-span-8">
                    <div class="rounded-2xl bg-white ring-1 ring-slate-200/70 shadow-lg shadow-slate-200/40 p-6 md:p-10">
                        
                        {{-- Meta Info --}}
                        <div class="text-sm text-gray-600 mb-6">
                           
                            @if($announcement->author)
                          
                            @endif
                        </div>
                        
                        {{-- Konten (TinyMCE) --}}
                        <div class="prose prose-slate prose-lg lg:prose-xl max-w-none prose-a:text-red-700 hover:prose-a:text-red-800 prose-img:rounded-xl">
                            {!! $announcement->content !!}
                        </div>

                        {{-- Lampiran Dokumen --}}
                        @if($announcement->document)
                        <div class="mt-10 p-6 bg-gray-100 rounded-lg border">
                            <h4 class="text-lg font-semibold mb-3">Lampiran Dokumen</h4>
                            <a href="{{ Storage::url($announcement->document->file_path) }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-red-700 text-white font-semibold rounded-lg hover:bg-red-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Unduh: {{ $announcement->document->title }}
                            </a>
                        </div>
                        @endif
                    </div>
                </article>

                {{-- SIDEBAR --}}
                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-24 space-y-6">
                        {{-- Include sidebar partial yang datanya sudah disiapkan di Controller --}}
                        @include('frontend.partials._sidebar', [
                            'latestAnnouncements' => $latestAnnouncements,
                            'latestEvents' => $latestEvents
                        ])
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection