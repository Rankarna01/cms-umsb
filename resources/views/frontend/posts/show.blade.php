@extends('layouts.frontend')

@section('title', $post->title)

@section('content')
    {{-- ===== Reading Progress Bar ===== --}}
    <div id="readingProgress" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-red-800 via-rose-500 to-orange-400 w-0 z-50"></div>

    {{-- ===== HERO HEADER (tema merah, dua kolom) ===== --}}
    <section class="relative isolate overflow-hidden">
      <div class="bg-gradient-to-br from-red-800 via-rose-600 to-red-500">
        <div class="container mx-auto px-6 py-10 md:py-14 lg:py-16">
          <div class="grid items-center gap-8 lg:grid-cols-12">
            {{-- KIRI: breadcrumb + judul + meta --}}
            <div class="lg:col-span-7 text-white">
              <nav class="text-white/80 text-sm mb-3">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('posts.index') }}" class="hover:text-white">Berita</a>
              </nav>

             <h1 class="text-2xl md:text-3xl lg:text-[28px] xl:text-[32px] font-extrabold leading-tight">
  {{ $post->title }}
</h1>
              <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-white/90 text-sm">
                <div>
                  <p class="opacity-90">Diterbitkan Pada</p>
                  <p class="mt-1 text-lg font-semibold">
                    {{ optional($post->created_at)->translatedFormat('d F Y') }}
                  </p>
                </div>
                <div>
                  <p class="opacity-90">Kategori</p>
                  <p class="mt-1 text-lg font-semibold">
                    {{ $post->category->name }}
                  </p>
                </div>
                @if(!empty($post->author?->name))
                  <div class="sm:col-span-2">
                  
                  </div>
                @endif
              </div>
            </div>

            {{-- KANAN: banner image dalam kartu putih --}}
            <div class="lg:col-span-5">
              <div class="relative rounded-3xl bg-white/95 shadow-xl ring-1 ring-black/5 overflow-hidden">
                <div class="p-3 md:p-4">
                  <div class="relative rounded-2xl overflow-hidden">
                    @if ($post->thumbnail)
                      <img
                        src="{{ Storage::url($post->thumbnail) }}"
                        alt="{{ $post->title }}"
                        class="w-full h-56 md:h-72 lg:h-80 object-cover transform transition-transform duration-700 hover:scale-[1.03]">
                    @else
                      <img
                        src="https://via.placeholder.com/960x540?text=No+Image"
                        alt="No image"
                        class="w-full h-56 md:h-72 lg:h-80 object-cover">
                    @endif

                    {{-- overlay lembut --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-black/0 to-transparent pointer-events-none"></div>

                    {{-- hiasan bulat transparan --}}
                    <div class="absolute -left-8 -top-8 h-24 w-24 rounded-full bg-rose-100/50 backdrop-blur-sm"></div>
                    <div class="absolute -right-10 -bottom-10 h-28 w-28 rounded-full bg-red-100/60 backdrop-blur-sm"></div>
                  </div>
                </div>
                <div class="h-3 bg-gradient-to-r from-rose-200 via-red-200 to-rose-200"></div>
              </div>
            </div>
          </div>
        </div>

        {{-- wave bawah hero --}}
        <svg class="block w-full text-white dark:text-gray-900" viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
          <path d="M0,64 C240,16 480,16 720,48 C960,80 1200,80 1440,48 L1440,80 L0,80 Z" fill="currentColor"/>
        </svg>
      </div>
    </section>
    {{-- ===== /HERO HEADER ===== --}}

    {{-- ===== Konten + Sidebar ===== --}}
    <div class="container mx-auto px-6 py-10">
      <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Konten utama --}}
         <article class="lg:col-span-8">
  <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg ring-1 ring-black/5">
    <div class="prose prose-base md:prose-lg max-w-none prose-img:rounded-xl prose-a:text-red-600 lg:text-[12px] leading-relaxed">
      {!! $post->content !!}
    </div>
  </div>
</article>
        {{-- Sidebar --}}
        <aside class="lg:col-span-4">
          <div class="sticky top-24 space-y-6">
            {{-- Berita Terbaru --}}
            <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg ring-1 ring-black/5 dark:ring-white/10">
              <h3 class="text-xl font-bold mb-4 border-b border-gray-100 dark:border-white/10 pb-2 text-gray-900 dark:text-gray-100">
                Berita Terbaru
              </h3>
              <ul class="space-y-4">
                @forelse(($latestPosts ?? collect()) as $latestPost)
                  <li>
                    <a href="{{ route('posts.show', $latestPost->slug) }}" class="group flex gap-4">
                      <div class="relative h-16 w-24 overflow-hidden rounded-lg shrink-0">
                        <img
                          src="{{ $latestPost->thumbnail ? Storage::url($latestPost->thumbnail) : 'https://via.placeholder.com/240x160?text=No+Image' }}"
                          alt="{{ $latestPost->title }}"
                          class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <span class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></span>
                      </div>
                      <div class="min-w-0">
                        <p class="text-sm font-semibold leading-snug line-clamp-2 text-gray-900 dark:text-gray-100 group-hover:text-red-600">
                          {{ $latestPost->title }}
                        </p>
                        <p class="mt-1 text-[12px] text-gray-500 dark:text-gray-400">
                          {{ optional($latestPost->created_at)->translatedFormat('d M Y') }}
                        </p>
                      </div>
                    </a>
                  </li>
                @empty
                  <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada berita terbaru.</p>
                @endforelse
              </ul>
            </div>

            {{-- Agenda Terdekat (opsional) --}}
            <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg ring-1 ring-black/5 dark:ring-white/10">
              <h3 class="text-xl font-bold mb-4 border-b border-gray-100 dark:border-white/10 pb-2 text-gray-900 dark:text-gray-100">
                Agenda Terdekat
              </h3>
              <ul class="space-y-4">
                @forelse(($upcomingEvents ?? collect()) as $event)
                  <li class="flex items-center space-x-4">
                    <div class="text-center bg-red-100 text-red-800 rounded-lg p-3 shrink-0 dark:bg-red-200 dark:text-red-800">
                      <p class="text-2xl font-bold">{{ optional($event->start_date)->format('d') }}</p>
                      <p class="text-xs uppercase">{{ optional($event->start_date)->format('M') }}</p>
                    </div>
                    <div>
                      <p class="font-semibold leading-snug line-clamp-2 text-gray-900 dark:text-gray-100">{{ $event->title }}</p>
                      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $event->location }}</p>
                    </div>
                  </li>
                @empty
                  <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada agenda terdekat.</p>
                @endforelse
              </ul>
            </div>
          </div>
        </aside>
      </div>
    </div>
    {{-- ===== /Konten + Sidebar ===== --}}

    {{-- Back to top --}}
    <button id="backToTop"
            class="hidden fixed bottom-6 right-6 p-3 rounded-full bg-red-600 text-white shadow-lg hover:bg-red-800 transition">
      <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 8l6 6H6z"/></svg>
    </button>

    {{-- Progress baca & back-to-top --}}
    <script>
      (function () {
        const progress = document.getElementById('readingProgress');
        const backToTop = document.getElementById('backToTop');

        function onScroll() {
          const doc = document.documentElement;
          const winH = window.innerHeight || doc.clientHeight;
          const scrollTop = doc.scrollTop || document.body.scrollTop;
          const scrollHeight = doc.scrollHeight || document.body.scrollHeight;
          const max = scrollHeight - winH;
          const percent = max > 0 ? (scrollTop / max) * 100 : 0;
          progress.style.width = percent + '%';
          if (scrollTop > 600) backToTop.classList.remove('hidden'); else backToTop.classList.add('hidden');
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
        backToTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
      })();
    </script>

    {{-- Style tambahan: justify paragraf & animasi ringan --}}
    <style>
      .prose p, .prose li { text-align: justify; text-justify: inter-word; }
      .content-body { hyphens: auto; overflow-wrap: anywhere; }
      @keyframes fadeIn { from {opacity: 0; transform: translateY(6px);} to {opacity: 1; transform: translateY(0);} }
    </style>
@endsection
