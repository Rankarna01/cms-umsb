@extends('layouts.frontend')

@section('title', 'Berita')

@section('content')
<div class="relative">
  {{-- Header seksi --}}
  <section class="relative overflow-hidden bg-gradient-to-br from-red-800 to-red-700 text-white">
    <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
    <div class="absolute -left-24 -bottom-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>

    <div class="container mx-auto px-6 py-14">
      <h1 class="text-3xl md:text-4xl font-extrabold text-center tracking-tight">Semua Berita</h1>
      <p class="mt-3 text-white/90 text-center max-w-2xl mx-auto">
        Kumpulan artikel terbaru dan pilihan untuk kamu baca hari ini.
      </p>
    </div>
  </section>

  {{-- Grid kartu berita --}}
  <section class="container mx-auto px-6 -mt-8 pb-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($posts as $post)
        <article class="group bg-white rounded-2xl shadow-sm ring-1 ring-black/5 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
          <a href="{{ route('posts.show', $post->slug) }}" class="relative block">
            <div class="aspect-[16/10] w-full overflow-hidden">
              <img
                src="{{ $post->thumbnail ? Storage::url($post->thumbnail) : 'https://via.placeholder.com/800x500?text=No+Image' }}"
                alt="{{ $post->title }}"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.05]" />
            </div>

            {{-- Overlay kategori --}}
            @if(!empty($post->category?->name))
            <span class="absolute top-3 left-3 inline-flex items-center gap-1 rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-red-700 shadow-sm">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-red-600"></span>
              {{ $post->category->name }}
            </span>
            @endif

            {{-- Gradien halus saat hover --}}
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </a>

          <div class="p-6">
            {{-- Meta --}}
            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
              @if(!empty($post->author?->name))
                <span class="inline-flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.7 0 4.8-2.2 4.8-4.8S14.7 2.4 12 2.4 7.2 4.6 7.2 7.2 9.3 12 12 12Zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8Z"/></svg>
                  {{ $post->author->name }}
                </span>
              @endif
              <span class="inline-flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h10a2 2 0 0 1 2 2v2H5V4a2 2 0 0 1 2-2Zm12 6H5v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8ZM9 12h6v2H9v-2Z"/></svg>
                {{ optional($post->created_at)->translatedFormat('d M Y') }}
              </span>
              @php
                $words = str($post->content ?? $post->excerpt ?? '')->wordCount();
                $mins = max(1, ceil($words / 200));
              @endphp
              <span class="inline-flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 8V4l8 8-8 8v-4H4V8h8Z"/></svg>
                {{ $mins }} menit baca
              </span>
            </div>

            {{-- Judul --}}
            <h3 class="mt-3 text-lg font-semibold leading-snug">
              <a href="{{ route('posts.show', $post->slug) }}" class="line-clamp-2 hover:text-red-600 transition-colors">
                {{ $post->title }}
              </a>
            </h3>

            {{-- Ringkasan --}}
            <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ Str::limit($post->excerpt, 160) }}</p>

            {{-- Aksi --}}
            <div class="mt-4 flex items-center justify-between">
              <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center gap-2 text-red-600 font-semibold hover:gap-3 transition-all">
                Baca selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M13.172 12 8.222 7.05l1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg>
              </a>

              @if(isset($post->tags) && $post->tags->count())
                <div class="hidden sm:flex flex-wrap gap-2">
                  @foreach($post->tags->take(2) as $tag)
                    <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-[11px] font-medium">#{{ $tag->name }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </article>
      @empty
        <p class="col-span-full text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
      @endforelse
    </div>

    {{-- Pagination (custom tema merah) --}}
    @if ($posts->hasPages())
    <nav role="navigation" aria-label="Pagination" class="mt-12 flex items-center justify-center">
      <ul class="inline-flex items-stretch overflow-hidden rounded-xl ring-1 ring-red-200 bg-white">
        {{-- Prev --}}
        @if ($posts->onFirstPage())
          <li><span class="px-3 py-2 text-sm text-red-300 border-r border-red-200">‹</span></li>
        @else
          <li><a href="{{ $posts->previousPageUrl() }}" rel="prev" class="px-3 py-2 text-sm text-red-700 border-r border-red-200 hover:bg-red-50 transition">‹</a></li>
        @endif

        {{-- Numbers --}}
        @foreach ($posts->links()->elements[0] ?? [] as $page => $url)
          @if ($page == $posts->currentPage())
            <li><span class="px-3 py-2 text-sm font-semibold bg-red-600 text-white border-r border-red-600">{{ $page }}</span></li>
          @else
            <li><a href="{{ $url }}" class="px-3 py-2 text-sm text-red-700 border-r border-red-200 hover:bg-red-50 hover:text-red-800 transition">{{ $page }}</a></li>
          @endif
        @endforeach

        {{-- Next --}}
        @if ($posts->hasMorePages())
          <li><a href="{{ $posts->nextPageUrl() }}" rel="next" class="px-3 py-2 text-sm text-red-700 hover:bg-red-50 transition">›</a></li>
        @else
          <li><span class="px-3 py-2 text-sm text-red-300 cursor-default">›</span></li>
        @endif
      </ul>
    </nav>
    @endif
  </section>
</div>
@endsection
