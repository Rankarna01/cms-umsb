@extends('layouts.frontend')

@section('title', $page->title)

@section('content')
  {{-- ===========================
       HERO / HEADER
  ============================ --}}
  @if ($page->header_image)
    <section class="relative w-full h-[42vh] md:h-[48vh] overflow-hidden">
      <div class="absolute inset-0">
        <img
          src="{{ Storage::url($page->header_image) }}"
          alt="{{ $page->title }}"
          class="w-full h-full object-cover">
      </div>

      {{-- overlay & soft gradient --}}
      <div class="absolute inset-0 bg-black/40"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/20 to-transparent"></div>

      <div class="relative h-full container mx-auto px-6 md:px-10 lg:px-16 flex items-end pb-10">
        <div class="w-full">
          <nav class="mb-2 text-sm text-white/70">
            <a href="{{ url('/') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="line-clamp-1">{{ $page->title }}</span>
          </nav>
          <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-white">
            {{ $page->title }}
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
          <span class="line-clamp-1">{{ $page->title }}</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">{{ $page->title }}</h1>
      </div>
    </header>
  @endif

  {{-- ===========================
       MAIN CONTENT + SIDEBAR
  ============================ --}}
  <main class="relative z-10">
    <div class="container mx-auto px-6 md:px-10 lg:px-16 py-10 md:py-14
      @if($page->header_image) -mt-10 md:-mt-14 @endif">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

        {{-- ARTICLE --}}
        <article class="lg:col-span-8">
          <div class="rounded-2xl bg-white ring-1 ring-slate-200/70 shadow-lg shadow-slate-200/40 p-6 md:p-10">
            {{-- konten rich --}}
            <div class="prose prose-slate prose-lg lg:prose-xl max-w-none prose-a:text-red-700 hover:prose-a:text-red-800 prose-img:rounded-xl">
              {!! $page->content !!}
            </div>

            {{-- tabel responsif bila ada --}}
            <div class="mt-6 overflow-x-auto rounded-xl ring-1 ring-slate-200/70" x-cloak>
              {{-- jika konten mengandung table, pembungkus ini akan membuatnya scrollable di mobile --}}
            </div>
          </div>
        </article>

        {{-- SIDEBAR --}}
        <aside class="lg:col-span-4">
          <div class="lg:sticky lg:top-24 space-y-6">

            {{-- BERITA TERBARU --}}
            <div class="rounded-2xl bg-white ring-1 ring-slate-200/70 shadow-md p-6">
              <h3 class="text-lg font-bold mb-4 pb-2 border-b border-slate-200">Berita Terbaru</h3>
              <ul class="space-y-4">
                @forelse($latestPosts as $latestPost)
                  <li>
                    <a href="{{ route('posts.show', $latestPost->slug) }}" class="group flex gap-4">
                      <div class="relative h-16 w-24 flex-shrink-0 overflow-hidden rounded-md ring-1 ring-slate-200">
                        <img
                          src="{{ $latestPost->thumbnail ? Storage::url($latestPost->thumbnail) : 'https://via.placeholder.com/240x160' }}"
                          alt="{{ $latestPost->title }}"
                          class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                      </div>
                      <div class="min-w-0">
                        <p class="text-sm font-semibold leading-snug line-clamp-2 group-hover:text-red-700">
                          {{ $latestPost->title }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                          {{ optional($latestPost->created_at)->translatedFormat('d M Y') }}
                        </p>
                      </div>
                    </a>
                  </li>
                @empty
                  <li class="text-sm text-slate-500">Tidak ada berita terbaru.</li>
                @endforelse
              </ul>
            </div>

            {{-- AGENDA TERDEKAT --}}
            <div class="rounded-2xl bg-white ring-1 ring-slate-200/70 shadow-md p-6">
              <h3 class="text-lg font-bold mb-4 pb-2 border-b border-slate-200">Agenda Terdekat</h3>
              <ul class="space-y-4">
                @forelse($upcomingEvents as $event)
                  <li class="flex items-center gap-4">
                    <div class="flex flex-col items-center justify-center rounded-lg bg-red-50 text-red-700 px-3 py-2 ring-1 ring-red-100">
                      <span class="text-xl font-extrabold leading-none">
                        {{ optional($event->start_date)->format('d') }}
                      </span>
                      <span class="text-[10px] uppercase tracking-widest">
                        {{ optional($event->start_date)->format('M') }}
                      </span>
                    </div>
                    <div class="min-w-0">
                      <p class="font-semibold leading-snug line-clamp-2">{{ $event->title }}</p>
                      <p class="mt-0.5 text-xs text-slate-500 line-clamp-1">{{ $event->location }}</p>
                    </div>
                  </li>
                @empty
                  <li class="text-sm text-slate-500">Tidak ada agenda terdekat.</li>
                @endforelse


                @if($quickLinks->isNotEmpty())
                    <div class="rounded-2xl bg-white ring-1 ring-slate-200/70 shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4 pb-2 border-b border-slate-200">Akses Cepat</h3>
                        <ul class="space-y-3">
                            @foreach($quickLinks as $link)
                                <li>
                                    <a href="{{ url($link->url) }}" class="flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-red-50 hover:text-red-700 font-medium transition-colors">
                                        <div class="flex-shrink-0 w-8 text-center">
                                            <i class="{{ $link->icon }} text-red-600 text-xl"></i>
                                        </div>
                                        <span>{{ $link->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
              </ul>
            </div>

          </div>
        </aside>
      </div>
    </div>
  </main>
@endsection
