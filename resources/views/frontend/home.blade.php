@extends('layouts.frontend')

@section('content')

    {{-- SECTION: HERO SLIDER --}}
    {{-- resources/views/sections/home_slider.blade.php --}}
    @if ($sliders->isNotEmpty())
        @foreach ($sliders as $slide)
            @php
                $images = $slide->images ?? collect();
                $imgCount = $images->count();
                $swiperId = 'image-swiper-' . $slide->id;
            @endphp

            @if ($imgCount > 0)
                <section class="w-full bg-white">
                    {{-- LAYOUT: SPLIT (teks kiri, gambar kanan yg slideshow) --}}
                    @if ($slide->layout === 'split')
                        <div class="w-full h-[72vh] md:h-[78vh] flex flex-col md:flex-row items-stretch">
                            {{-- Teks kiri (statis) --}}
                            <div class="w-full md:w-1/2 flex items-center justify-center px-6 md:px-10 lg:px-16 py-10">
                                <div class="max-w-2xl text-center md:text-left">
                                    <h1
                                        class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.05] tracking-tight text-red-700">
                                        {{ $slide->title }}
                                    </h1>
                                    @if (!empty($slide->caption))
                                        <p class="mt-5 text-lg md:text-xl text-slate-800">{{ $slide->caption }}</p>
                                    @endif
                                    @if ($slide->link_url && $slide->button_text)
                                        <a href="{{ $slide->link_url }}"
                                            class="mt-8 inline-flex items-center gap-2 rounded-full bg-red-800 hover:bg-red-700 text-white font-semibold px-6 md:px-8 py-3 shadow-lg shadow-red-800/20 transition">
                                            {{ $slide->button_text }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M13.172 12 8.222 7.05l1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Gambar kanan (Swiper hanya di area ini) --}}
                            <div
                                class="w-full md:w-1/2 h-[36vh] md:h-full flex items-center justify-center px-6 md:px-10 lg:px-16 pb-10 md:pb-0">
                                <div
                                    class="relative w-full max-w-3xl aspect-[16/9] rounded-3xl overflow-hidden ring-1 ring-slate-200 shadow-2xl">
                                    <div id="{{ $swiperId }}" class="image-swiper h-full w-full">
                                        <div class="swiper-wrapper">
                                            @foreach ($images as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ Storage::url($image->image_path) }}"
                                                        alt="{{ $slide->title }}" class="h-full w-full object-cover" />
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- optional controls untuk area gambar --}}
                                        <div class="swiper-pagination"></div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LAYOUT: FULL WIDTH (banner; teks overlay statis; gambar di belakang slideshow) --}}
                    @else
                        <div class="relative w-full h-[72vh] md:h-[78vh]">
                            <div id="{{ $swiperId }}" class="image-swiper absolute inset-0">
                                <div class="swiper-wrapper">
                                    @foreach ($images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $slide->title }}"
                                                class="h-full w-full object-cover" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Overlay gelap biar teks kebaca --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent pointer-events-none">
                            </div>

                            {{-- Teks overlay (statis) --}}
                            <div
                                class="relative h-full container mx-auto px-6 md:px-10 lg:px-16 flex items-center justify-center">
                                <div class="max-w-3xl w-full text-center text-white">
                                    <h1 class="text-4xl md:text-6xl font-bold leading-tight">{{ $slide->title }}</h1>
                                    @if (!empty($slide->caption))
                                        <p class="mt-4 text-lg md:text-xl">{{ $slide->caption }}</p>
                                    @endif
                                    @if ($slide->link_url && $slide->button_text)
                                        <a href="{{ $slide->link_url }}"
                                            class="mt-8 inline-flex items-center gap-2 rounded-full bg-red-800 hover:bg-red-700 text-white font-semibold px-6 md:px-8 py-3 shadow-lg shadow-red-800/20 transition">
                                            {{ $slide->button_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- optional controls untuk background banner --}}
                            <div class="absolute inset-x-0 bottom-4 flex items-center justify-center">
                                <div class="flex items-center gap-4">
                                    <div class="swiper-button-prev !static !translate-x-0"></div>
                                    <div class="swiper-pagination !static"></div>
                                    <div class="swiper-button-next !static !translate-x-0"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.image-swiper').forEach(function(el) {
                            const slidesCount = el.querySelectorAll('.swiper-slide').length;

                            new Swiper(el, {
                                // HANYA gambar yang slide, konten lain statis
                                loop: slidesCount > 1,
                                autoplay: slidesCount > 1 ? {
                                    delay: 4000,
                                    disableOnInteraction: false,
                                } : false,
                                speed: 700,
                                // boleh pakai effect fade untuk banner; untuk split biasanya slide biasa
                                effect: el.closest('[data-effect="fade"]') ? 'fade' : 'slide',
                                fadeEffect: {
                                    crossFade: true
                                },

                                pagination: {
                                    el: el.querySelector('.swiper-pagination'),
                                    clickable: true,
                                },
                                navigation: {
                                    nextEl: el.querySelector('.swiper-button-next'),
                                    prevEl: el.querySelector('.swiper-button-prev'),
                                },
                                // biar Swiper reflow saat container berubah
                                observer: true,
                                observeParents: true,
                            });
                        });
                    });
                </script>
            @endif
        @endforeach
    @endif

    {{-- SECTION: KUMPULAN BERITA PER KATEGORI --}}
    @if ($categoriesWithPosts->isNotEmpty())
        {{-- Loop untuk SETIAP KATEGORI yang ditemukan --}}
        @foreach ($categoriesWithPosts as $category)
            <section class="py-16 lg:py-20">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                    {{-- Beri garis pemisah antar kategori, kecuali yang pertama --}}
                    <div class="{{ $loop->first ? '' : 'border-t border-slate-200 pt-12' }}">

                        <div class="mb-10 flex items-center justify-between">
                            {{-- Judul section diambil dari nama Kategori --}}
                            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
                                {{ $category->name }}
                            </h2>

                            {{-- Tombol Lihat Semua --}}
                            <a href="{{ route('posts.index') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl ring-1 ring-slate-300 hover:ring-red-300 text-red-700 hover:bg-red-50 transition">
                                Lihat semua
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M13 5l7 7-7 7-1.41-1.41L16.17 13H4v-2h12.17l-4.58-4.59L13 5z" />
                                </svg>
                            </a>
                        </div>

                        {{-- 
                    // ==========================================================
                    // ## PERUBAHAN GRID: lg:grid-cols-5 diubah menjadi lg:grid-cols-3
                    // ==========================================================
                    --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                            {{-- Loop ini sekarang PASTI hanya 3 (atau kurang) --}}
                            @foreach ($category->posts as $post)
                                {{-- 
                            // ==========================================================
                            // ## KARTU BERITA DENGAN STYLE BARU (SESUAI GAMBAR)
                            // ==========================================================
                            --}}
                                <article
                                    class="group rounded-2xl overflow-hidden bg-white ring-1 ring-slate-200 hover:ring-red-300 hover:shadow-xl transition flex flex-col">
                                    {{-- Kita buat <a> sebagai flex-col agar seluruh kartu adalah link --}}
                                    <a href="{{ route('posts.show', $post->slug) }}" class="block h-full flex flex-col">

                                        {{-- Bagian Gambar --}}
                                        <div class="relative aspect-[16/10] overflow-hidden">
                                            <img src="{{ $post->thumbnail ? Storage::url($post->thumbnail) : 'https://via.placeholder.com/640x400' }}"
                                                alt="{{ $post->title }}"
                                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        </div>

                                        {{-- Bagian Konten --}}
                                        {{-- flex-grow agar block ini mengisi sisa ruang --}}
                                        <div class="p-4 flex flex-col flex-grow">

                                            {{-- Blok Meta Tags (Tanggal & Kategori) --}}
                                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                                {{-- Tag Tanggal (Style Merah) --}}
                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">
                                                    {{-- Icon Kalender --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{-- Format tanggal seperti di gambar Anda --}}
                                                    {{ $post->created_at->translatedFormat('d M Y') }}
                                                </span>

                                                {{-- Tag Kategori (Style Biru, agar beda) --}}
                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                                    {{-- Icon Tag --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a1 1 0 011-1h5a.997.997 0 01.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $category->name }}
                                                </span>
                                            </div>

                                            {{-- Judul Berita --}}
                                            {{-- line-clamp-3 agar bisa 3 baris seperti di gambar --}}
                                            <h3
                                                class="text-lg font-semibold leading-snug text-slate-900 line-clamp-3 group-hover:text-red-700 flex-grow">
                                                {{ $post->title }}
                                            </h3>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif


    {{-- SECTION: FAKTA KAMPUS --}}
    @if ($factoids->isNotEmpty())
        <section class="relative overflow-hidden py-16 lg:py-20">
            {{-- Decorative background --}}
            <div class="absolute inset-0 -z-10">
                <div class="absolute -top-24 -right-24 h-80 w-80 rounded-full blur-3xl opacity-30"
                    style="background: radial-gradient(50% 50% at 50% 50%, #ef4444 0%, rgba(239,68,68,0) 70%);"></div>
                <div class="absolute -bottom-28 -left-28 h-96 w-96 rounded-full blur-3xl opacity-25"
                    style="background: radial-gradient(50% 50% at 50% 50%, #10b981 0%, rgba(16,185,129,0) 70%);"></div>
                <div class="absolute inset-0 opacity-[0.08]"
                    style="background-image: linear-gradient(to right, #0f172a 1px, transparent 1px),
                linear-gradient(to bottom, #0f172a 1px, transparent 1px);
                background-size: 32px 32px;">
                </div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-xs font-semibold tracking-widest uppercase text-red-800/90">Fakta Kampus</h2>
                    <p class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
                        UM Sumatera Barat dalam Angka
                    </p>
                    <p class="mt-3 text-sm text-slate-800">Data ringkas yang kami banggakan</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                    @foreach ($factoids as $factoid)
                        <div class="group relative rounded-2xl bg-white/60 backdrop-blur-xl ring-1 ring-slate-200
                  hover:ring-red-300 transition-all duration-300
                  hover:-translate-y-1 hover:shadow-xl"
                            style="animation: factoid-fade 800ms both; animation-delay: {{ $loop->index * 80 }}ms">
                            {{-- subtle gradient border glow on hover --}}
                            <div
                                class="pointer-events-none absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition
                    bg-gradient-to-br from-red-500/10 via-rose-500/5 to-emerald-500/10">
                            </div>

                            <div class="relative px-4 py-6 sm:px-6 sm:py-8 text-center">
                                <div
                                    class="mx-auto mb-4 sm:mb-5 w-16 h-16 sm:w-20 sm:h-20 rounded-full grid place-items-center
                      bg-gradient-to-br from-red-800 to-rose-800 text-white text-2xl sm:text-3xl shadow-lg
                      ring-1 ring-white/20
                      transition-transform duration-300 group-hover:scale-105 group-hover:rotate-[2deg]">
                                    <i class="{{ $factoid->icon ?? 'fa-solid fa-graduation-cap' }}"></i>
                                </div>

                                {{-- angka dengan animasi count-up --}}
                                <p class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 tabular-nums
                    will-change-contents"
                                    data-countup data-target="{{ $factoid->value }}">{{ $factoid->value }}</p>

                                <p class="mt-1 text-slate-800 text-sm sm:text-base">{{ $factoid->label }}</p>

                                {{-- underline accent on hover --}}
                                <span
                                    class="mt-3 block h-px w-10 mx-auto bg-gradient-to-r from-transparent via-red-500/60 to-transparent
                        opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- styles kecil untuk animasi masuk --}}
        <style>
            @keyframes factoid-fade {
                from {
                    opacity: 0;
                    transform: translateY(8px) scale(.98);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                [data-countup] {
                    transition: none !important;
                }
            }
        </style>

        {{-- count-up angka saat section terlihat (tanpa lib) --}}
        <script>
            (function() {
                const ease = (t) => 1 - Math.pow(1 - t, 3); // easeOutCubic
                const els = document.querySelectorAll('[data-countup]');
                if (!('IntersectionObserver' in window) || els.length === 0) return;

                const parseNum = (s) => {
                    const n = (s + '').replace(/[^\d.,]/g, '').replace(/\.(?=.*\.)/g, '').replace(',', '.');
                    const v = parseFloat(n);
                    return isNaN(v) ? 0 : v;
                };

                const format = (v) => {
                    try {
                        return new Intl.NumberFormat('id-ID').format(Math.round(v));
                    } catch {
                        return Math.round(v).toString();
                    }
                };

                const animate = (el, target) => {
                    const dur = 1200; // ms
                    const start = performance.now();
                    const from = 0;
                    const step = (now) => {
                        const t = Math.min(1, (now - start) / dur);
                        const val = from + (target - from) * ease(t);
                        el.textContent = format(val);
                        if (t < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                };

                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const el = entry.target;
                            const target = parseNum(el.getAttribute('data-target') || '0');
                            // cegah animasi berulang
                            if (!el.dataset.done) {
                                el.dataset.done = '1';
                                animate(el, target);
                            }
                            io.unobserve(el);
                        }
                    });
                }, {
                    threshold: 0.25
                });

                els.forEach(el => io.observe(el));
            })();
        </script>
    @endif

    <!-- QUICK LINKS Section -->
    @if ($quickLinks->isNotEmpty())
        <section class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($quickLinks as $link)
                    <a href="{{ url($link->url) }}"
                        class="group relative overflow-hidden rounded-2xl bg-white p-6 text-center
                shadow-sm ring-1 ring-gray-100
                transition-all duration-300
                hover:-translate-y-1 hover:shadow-xl hover:ring-red-200 focus:outline-none focus:ring-2 focus:ring-red-400"
                        rel="noopener">

                        {{-- Glow dekoratif --}}
                        <div
                            class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 w-28 h-28 rounded-full bg-red-400 opacity-10 blur-2xl transition group-hover:opacity-20">
                        </div>

                        {{-- Ikon dalam lingkaran gradien --}}
                        <div
                            class="mx-auto mb-4 w-24 h-24 rounded-full p-[3px]
                    bg-gradient-to-br from-red-800 via-rose-500 to-pink-500">
                            <div
                                class="flex h-full w-full items-center justify-center rounded-full
                      bg-white text-red-700 ring-4 ring-red-50
                      transition-colors duration-300 group-hover:bg-red-800 group-hover:text-white">
                                <i class="{{ $link->icon }} text-4xl"></i>
                            </div>
                        </div>

                        {{-- Judul --}}
                        <h3 class="font-semibold text-gray-900 tracking-tight line-clamp-2">
                            {{ $link->title }}
                        </h3>

                        {{-- Tombol tiny --}}
                        <span
                            class="mt-3 inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-medium
                     bg-red-100 text-red-700
                     transition-colors duration-300
                     group-hover:bg-red-700 group-hover:text-white">
                            Pelajari Selengkapnya
                        </span>

                        {{-- Border bottom gradien saat hover --}}
                        <span
                            class="pointer-events-none absolute inset-x-0 bottom-0 h-1
                     bg-gradient-to-r from-red-800 via-rose-500 to-pink-500
                     opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if ($academicServices->isNotEmpty())
        <section class="bg-gray-50 py-16 lg:py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Informasi Layanan Akademik</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($academicServices as $service)
                        <a href="{{ url($service->url) }}" target="_blank"
                            class="block bg-white p-8 rounded-2xl shadow-lg ring-1 ring-slate-200/70 text-center group hover:-translate-y-2 transition-transform duration-300">
                            @if ($service->image)
                                <img class="h-24 w-24 rounded-full object-cover mx-auto mb-4"
                                    src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}">
                            @endif
                            <h3 class="font-bold text-xl text-blue-800 group-hover:text-red-800 transition-colors">
                                {{ $service->title }}</h3>
                            <p class="text-slate-800 mt-2 text-sm">{{ $service->description }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif



    @if ($galleryPhotos->isNotEmpty())
        <section class="container mx-auto px-6 md:px-10 lg:px-16 py-12 md:py-16">
            {{-- Header --}}
            <div class="text-center mb-10">
                <span class="inline-block text-red-800 font-extrabold tracking-widest uppercase text-xs sm:text-sm">
                    Dokumentasi
                </span>
                <h2 class="mt-2 text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                    Galeri Foto Kegiatan
                </h2>
                <div class="mt-4 flex items-center justify-center">
                    <span class="h-0.5 w-16 bg-red-800 rounded-full"></span>
                    <span class="mx-2 text-slate-400">•</span>
                    <span class="h-0.5 w-16 bg-slate-200 rounded-full"></span>
                </div>
            </div>

            {{-- GRID FOTO --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($galleryPhotos as $photo)
                    @php
                        $src = method_exists($photo, 'getImageUrlAttribute')
                            ? $photo->image_url
                            : Storage::url($photo->image_path);
                        $ttl = $photo->title ?? 'Galeri Foto';
                    @endphp
                    <button type="button"
                        class="group relative overflow-hidden rounded-2xl ring-1 ring-slate-200/80 bg-white hover:ring-red-300 hover:shadow-xl transition"
                        data-src="{{ $src }}" data-title="{{ $ttl }}"
                        aria-label="Lihat foto: {{ $ttl }}">
                        <img src="{{ $src }}" alt="{{ $ttl }}"
                            class="w-full aspect-[4/3] object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy" decoding="async" />
                        <div
                            class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent">
                        </div>
                        <div class="absolute inset-x-0 bottom-0 p-3">
                            <h3 class="text-white text-xs sm:text-sm font-semibold line-clamp-1 drop-shadow">
                                {{ $ttl }}
                            </h3>
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- PAGINATION (custom) --}}
            @if ($galleryPhotos->hasPages())
                @php
                    $current = $galleryPhotos->currentPage();
                    $last = $galleryPhotos->lastPage();
                    $start = max(1, $current - 1);
                    $end = min($last, $current + 1);
                    if ($current <= 2) {
                        $end = min($last, 3);
                    }
                    if ($current >= $last - 1) {
                        $start = max(1, $last - 2);
                    }
                @endphp

                <nav class="mt-10 flex items-center justify-center" aria-label="Pagination galeri">
                    <ul class="inline-flex items-center gap-2">
                        {{-- Prev --}}
                        <li>
                            @if ($galleryPhotos->onFirstPage())
                                <span
                                    class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-1 ring-slate-200 text-slate-400 cursor-not-allowed select-none">
                                    ‹ Sebelumnya
                                </span>
                            @else
                                <a href="{{ $galleryPhotos->previousPageUrl() }}"
                                    class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-1 ring-slate-300 hover:ring-red-300 text-slate-700 hover:text-red-700 bg-white hover:bg-red-50 transition">
                                    ‹ Sebelumnya
                                </a>
                            @endif
                        </li>

                        {{-- First + ellipsis --}}
                        @if ($start > 1)
                            <li>
                                <a href="{{ $galleryPhotos->url(1) }}"
                                    class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-1 ring-slate-300 hover:ring-red-300 text-slate-700 hover:text-red-700 bg-white hover:bg-red-50 transition">
                                    1
                                </a>
                            </li>
                            @if ($start > 2)
                                <li><span class="px-2 text-slate-400 select-none">…</span></li>
                            @endif
                        @endif

                        {{-- Middle pages --}}
                        @for ($i = $start; $i <= $end; $i++)
                            @if ($i == $current)
                                <li>
                                    <span
                                        class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-2 ring-red-500 text-red-700 bg-red-50 font-semibold">
                                        {{ $i }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $galleryPhotos->url($i) }}"
                                        class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-1 ring-slate-300 hover:ring-red-300 text-slate-700 hover:text-red-700 bg-white hover:bg-red-50 transition">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endif
                        @endfor

                        {{-- Last + ellipsis --}}
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <li><span class="px-2 text-slate-400 select-none">…</span></li>
                            @endif
                            <li>
                                <a href="{{ $galleryPhotos->url($last) }}"
                                    class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-1 ring-slate-300 hover:ring-red-300 text-slate-700 hover:text-red-700 bg-white hover:bg-red-50 transition">
                                    {{ $last }}
                                </a>
                            </li>
                        @endif

                        {{-- Next --}}
                        <li>
                            @if ($galleryPhotos->hasMorePages())
                                <a href="{{ $galleryPhotos->nextPageUrl() }}"
                                    class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-1 ring-slate-300 hover:ring-red-300 text-slate-700 hover:text-red-700 bg-white hover:bg-red-50 transition">
                                    Berikutnya ›
                                </a>
                            @else
                                <span
                                    class="inline-flex items-center rounded-xl px-3 py-2 text-sm ring-1 ring-slate-200 text-slate-400 cursor-not-allowed select-none">
                                    Berikutnya ›
                                </span>
                            @endif
                        </li>
                    </ul>
                </nav>
            @endif
        </section>

        {{-- MODAL FOTO (tengah layar, sekali saja di halaman) --}}
        <div id="galleryModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm">
            {{-- grid center --}}
            <div class="grid place-items-center w-full h-full p-4">
                <div class="relative w-full max-w-5xl">
                    <figure id="gmCard" class="opacity-0 scale-95 transition-all duration-200 ease-out">
                        <img id="gmImg" src="" alt=""
                            class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl bg-white" />
                        <figcaption id="gmTitle" class="mt-3 text-white/90 text-sm font-medium text-center">
                        </figcaption>
                    </figure>

                    {{-- Close --}}
                    <button id="gmClose"
                        class="absolute -top-3 -right-3 rounded-full bg-white text-slate-700 w-9 h-9 shadow hover:shadow-lg transition ring-1 ring-slate-200 flex items-center justify-center"
                        aria-label="Tutup">
                        ✕
                    </button>
                </div>
            </div>
        </div>

        {{-- JS modal ringan (fade + scale + esc/backdrop) --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('galleryModal');
                const card = document.getElementById('gmCard');
                const imgEl = document.getElementById('gmImg');
                const titleEl = document.getElementById('gmTitle');
                const closeEl = document.getElementById('gmClose');

                const open = (src, ttl) => {
                    const img = new Image();
                    img.onload = () => {
                        imgEl.src = src;
                        titleEl.textContent = ttl || '';
                        modal.classList.remove('hidden');
                        document.documentElement.style.overflow = 'hidden';
                        requestAnimationFrame(() => {
                            card.classList.remove('opacity-0', 'scale-95');
                            card.classList.add('opacity-100', 'scale-100');
                        });
                    };
                    img.src = src;
                };

                const close = () => {
                    card.classList.remove('opacity-100', 'scale-100');
                    card.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        imgEl.src = '';
                        titleEl.textContent = '';
                        document.documentElement.style.overflow = '';
                    }, 180);
                };

                document.querySelectorAll('[data-src]').forEach(btn => {
                    btn.addEventListener('click', () => open(btn.dataset.src, btn.dataset.title));
                });

                closeEl.addEventListener('click', close);

                // klik backdrop -> tutup (pastikan tidak menutup saat klik isi card)
                modal.addEventListener('click', (e) => {
                    const centerWrap = modal.querySelector('.grid');
                    if (e.target === modal || e.target === centerWrap) close();
                });

                window.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
                });
            });
        </script>



        {{-- Script untuk modal (tidak berubah) --}}
    @endif

    <!-- GALERI VIDEO Section -->
    @if ($latestVideos->isNotEmpty())
        <section class="bg-white text-slate-900">
            <div class="container mx-auto px-6 py-12 md:py-16">
                <div class="text-center mb-10">
                    <span
                        class="inline-block text-red-800 font-extrabold tracking-widest uppercase text-xs sm:text-sm">Galeri</span>
                    <h2 class="mt-2 text-2xl sm:text-3xl font-bold">Galeri Video</h2>
                    <p class="mt-1 text-slate-500">Liputan dan dokumentasi kegiatan dalam format video.</p>
                </div>

                {{-- GRID Kartu Video (thumbnail saja, tanpa iframe -> ringan) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                    @foreach ($latestVideos as $video)
                        <button type="button"
                            class="video-play-button group relative block overflow-hidden rounded-2xl ring-1 ring-slate-200 hover:ring-red-300 bg-white hover:shadow-xl transition"
                            data-embed-url="{{ $video->embed_url }}" aria-label="Putar: {{ $video->title }}">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
                                class="w-full aspect-[16/9] object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy" decoding="async" />
                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent">
                            </div>

                            {{-- Play button --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="p-4 rounded-full bg-red-800/95 group-hover:bg-red-800 transition-transform duration-300 scale-95 group-hover:scale-100 shadow-lg shadow-red-800/30">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Title --}}
                            <div class="absolute inset-x-0 bottom-0 p-4">
                                <h3 class="text-white font-semibold text-sm sm:text-base line-clamp-2 drop-shadow">
                                    {{ $video->title }}</h3>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- MODAL VIDEO: 1 iframe saja (di-set saat open, dihapus saat close) --}}
        <div id="videoModal" class="fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black/80" data-close></div>

            <div class="absolute inset-0 flex items-center justify-center p-4">
                <div class="relative w-full max-w-6xl">
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-black ring-1 ring-white/10">
                        <iframe id="videoPlayer" class="absolute inset-0 w-full h-full" src=""
                            title="Pemutar Video" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin">
                        </iframe>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button id="closeVideoModal"
                            class="inline-flex items-center gap-2 rounded-lg bg-white/10 hover:bg-white/20 text-white px-4 py-2 ring-1 ring-white/20">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- JS ringan: set/unset src saat buka/tutup --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const videoModal = document.getElementById('videoModal');
                const videoPlayer = document.getElementById('videoPlayer');
                const closeBtn = document.getElementById('closeVideoModal');
                const playButtons = document.querySelectorAll('.video-play-button');

                const open = (embedUrl) => {
                    // Optimisasi kecil untuk YouTube: tambahkan parameter agar clean & cepat
                    try {
                        const url = new URL(embedUrl);
                        if ((/youtube\.com|youtu\.be/).test(url.host)) {
                            if (!url.searchParams.has('autoplay')) url.searchParams.set('autoplay', '1');
                            url.searchParams.set('rel', '0');
                            url.searchParams.set('modestbranding', '1');
                            embedUrl = url.toString();
                        }
                    } catch (_) {}

                    videoPlayer.src = embedUrl;
                    videoModal.classList.remove('hidden');
                    document.documentElement.style.overflow = 'hidden';
                };

                const close = () => {
                    videoModal.classList.add('hidden');
                    videoPlayer.src = ''; // hentikan video -> anti lag
                    document.documentElement.style.overflow = '';
                };

                playButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const embedUrl = btn.dataset.embedUrl;
                        if (embedUrl) open(embedUrl);
                    });
                });

                closeBtn.addEventListener('click', close);
                videoModal.addEventListener('click', (e) => {
                    if (e.target === videoModal || e.target.hasAttribute('data-close')) close();
                });

                window.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !videoModal.classList.contains('hidden')) close();
                });
            });
        </script>
    @endif



    {{-- SECTION: AGENDA --}}
    @if ($latestAnnouncements->isNotEmpty() || $latestEvents->isNotEmpty())
        <section class="py-16 lg:py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Grid 2 kolom --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

                    {{-- Kolom 1: Pengumuman (Merah Tua) --}}
                    <div class="bg-red-800 text-white rounded-2xl shadow-xl p-8 lg:p-10 relative overflow-hidden">
                        {{-- Efek dekorasi background --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-red-800 opacity-80 rounded-2xl"></div>

                        <div class="relative z-10">
                            <h2 class="text-3xl font-extrabold mb-6 border-b border-red-800 pb-2">Pengumuman</h2>

                            <ul class="space-y-5">
                                @foreach ($latestAnnouncements as $announcement)
                                    <li>
                                        <a href="{{ route('announcements.show', $announcement->slug) }}"
                                            class="group flex items-start gap-4 transition transform hover:translate-x-1">
                                            {{-- Icon --}}
                                            <div class="flex-shrink-0 text-yellow-400 mt-1">
                                                <i class="fa-solid fa-bullhorn text-lg"></i>
                                            </div>
                                            {{-- Konten --}}
                                            <div>
                                                <h3
                                                    class="font-semibold text-white group-hover:text-yellow-300 transition line-clamp-2">
                                                    {{ $announcement->title }}
                                                </h3>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div> {{-- Akhir Kolom Pengumuman --}}

                    {{-- Kolom 2: Agenda (Putih) --}}
                    <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-10 ring-1 ring-slate-200/70">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-2">Agenda</h2>

                        <ul class="space-y-5">
                            @foreach ($latestEvents as $event)
                                <li>
                                    <a href="{{ route('events.show', $event->slug) }}"
                                        class="group block transition transform hover:translate-x-1">
                                        <span class="text-sm text-red-700 font-semibold block">
                                            {{ $event->start_date->translatedFormat('d F Y') }}
                                        </span>
                                        <h3
                                            class="font-semibold text-gray-800 group-hover:text-red-700 transition line-clamp-2">
                                            {{ $event->title }}
                                        </h3>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div> {{-- Akhir Kolom Agenda --}}

                </div>
            </div>
        </section>
    @endif


    {{-- SECTION: PIMPINAN --}}
    @if ($leaders->isNotEmpty())
<section class="relative bg-white py-16">
  <div class="container relative mx-auto px-6">
    {{-- Judul --}}
    <div class="text-center mb-12">
      <span class="inline-block text-red-800 font-extrabold tracking-widest uppercase text-sm border-b-2 border-red-500 pb-1">
        Pimpinan Universitas
      </span>
      <p class="mt-2 text-slate-500 text-sm sm:text-base">Struktur kepemimpinan dan jajaran universitas.</p>
    </div>

    {{-- MOBILE: Slider manual (tanpa swiper/marquee) --}}
    <div class="sm:hidden">
      <div class="flex items-center justify-between mb-4">
        <button type="button"
                class="inline-flex items-center justify-center h-10 w-10 rounded-full ring-1 ring-slate-300 text-slate-700 hover:bg-slate-50 active:scale-95"
                aria-label="Geser kiri"
                onclick="document.getElementById('leadersScroller').scrollBy({ left: -280, behavior: 'smooth' })">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button type="button"
                class="inline-flex items-center justify-center h-10 w-10 rounded-full ring-1 ring-slate-300 text-slate-700 hover:bg-slate-50 active:scale-95"
                aria-label="Geser kanan"
                onclick="document.getElementById('leadersScroller').scrollBy({ left: 280, behavior: 'smooth' })">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>

      <div id="leadersScroller"
           class="overflow-x-auto no-scrollbar snap-x snap-mandatory -mx-2 px-2">
        <ul class="flex items-stretch gap-4">
          @foreach ($leaders as $leader)
            <li class="shrink-0 snap-center">
              {{-- kartu dengan ukuran konsisten --}}
              <div class="w-64 h-[22rem] sm:w-72 rounded-2xl bg-white ring-1 ring-slate-200 hover:ring-red-400 hover:shadow-xl transition-all duration-300 overflow-hidden text-center p-5 flex flex-col">
                <div class="relative mx-auto mb-3 overflow-hidden rounded-xl w-52 h-56">
                  <img
                    src="{{ $leader->photo ? Storage::url($leader->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($leader->name) . '&size=256' }}"
                    alt="{{ $leader->name }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 group-hover:brightness-110">
                </div>

                {{-- blok teks fixed height agar semua kotak sama --}}
                <div class="px-1">
                  <h3 class="text-base font-bold text-slate-800 line-clamp-2 min-h-[2.75rem]">
                    {{ $leader->name }}
                  </h3>
                  <p class="text-slate-500 text-xs line-clamp-2 min-h-[2rem]">
                    {{ $leader->position }}
                  </p>
                </div>

                {{-- social di bawah --}}
                <div class="mt-auto pt-3 flex justify-center gap-3">
                  @if ($leader->social_facebook)
                    <a href="{{ $leader->social_facebook }}" target="_blank" class="text-gray-400 hover:text-blue-800 transition">
                      <i class="fa-brands fa-facebook-f text-lg"></i>
                    </a>
                  @endif
                  @if ($leader->social_instagram)
                    <a href="{{ $leader->social_instagram }}" target="_blank" class="text-gray-400 hover:text-pink-500 transition">
                      <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                  @endif
                  @if ($leader->social_linkedin)
                    <a href="{{ $leader->social_linkedin }}" target="_blank" class="text-gray-400 hover:text-blue-700 transition">
                      <i class="fa-brands fa-linkedin-in text-lg"></i>
                    </a>
                  @endif
                  @if ($leader->social_x)
                    <a href="{{ $leader->social_x }}" target="_blank" class="text-gray-400 hover:text-gray-800 transition">
                      <i class="fa-brands fa-x-twitter text-lg"></i>
                    </a>
                  @endif
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    {{-- DESKTOP/TABLET: Grid responsif (kotak seragam, tidak tergantung teks) --}}
    <div class="hidden sm:block">
      <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($leaders as $leader)
          <li>
            <div class="rounded-2xl bg-white ring-1 ring-slate-200 hover:ring-red-400 hover:shadow-xl transition-all duration-300 overflow-hidden text-center p-6 flex flex-col h-full">
              <div class="relative mx-auto mb-4 overflow-hidden rounded-xl w-52 h-56">
                <img
                  src="{{ $leader->photo ? Storage::url($leader->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($leader->name) . '&size=256' }}"
                  alt="{{ $leader->name }}"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 group-hover:brightness-110">
              </div>

              {{-- blok teks fixed height agar tinggi kartu konsisten --}}
              <div class="px-2">
                <h3 class="text-lg font-bold text-slate-800 line-clamp-2 min-h-[2.75rem]">
                  {{ $leader->name }}
                </h3>
                <p class="text-slate-500 text-sm line-clamp-2 min-h-[2.25rem]">
                  {{ $leader->position }}
                </p>
              </div>

              <div class="mt-auto pt-4 flex justify-center gap-3">
                @if ($leader->social_facebook)
                  <a href="{{ $leader->social_facebook }}" target="_blank" class="text-gray-400 hover:text-blue-800 transition">
                    <i class="fa-brands fa-facebook-f text-xl"></i>
                  </a>
                @endif
                @if ($leader->social_instagram)
                  <a href="{{ $leader->social_instagram }}" target="_blank" class="text-gray-400 hover:text-pink-500 transition">
                    <i class="fa-brands fa-instagram text-xl"></i>
                  </a>
                @endif
                @if ($leader->social_linkedin)
                  <a href="{{ $leader->social_linkedin }}" target="_blank" class="text-gray-400 hover:text-blue-700 transition">
                    <i class="fa-brands fa-linkedin-in text-xl"></i>
                  </a>
                @endif
                @if ($leader->social_x)
                  <a href="{{ $leader->social_x }}" target="_blank" class="text-gray-400 hover:text-gray-800 transition">
                    <i class="fa-brands fa-x-twitter text-xl"></i>
                  </a>
                @endif
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</section>
@endif


    {{-- SECTION: DOSEN --}}

    {{-- SECTION: KERJA SAMA --}}
    @if ($partners->isNotEmpty())
        <section class="bg-white py-14 lg:py-18 relative overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Judul (tetap) --}}
                <div class="text-center mb-12">
                    <span
                        class="inline-block text-red-800 font-extrabold tracking-widest uppercase text-sm border-b-2 border-red-500 pb-1">
                        Koneksi
                    </span>
                    <p class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900">Mitra Kerja Sama</p>
                </div>

                {{-- Fade kiri/kanan biar halus --}}
                <div class="pointer-events-none absolute inset-0 mask-gradient"></div>

                {{-- Container: mobile bisa geser manual + snap; ≥sm auto-marquee --}}
                <div class="overflow-x-auto sm:overflow-hidden snap-x snap-mandatory no-scrollbar">
                    {{-- Track: duplikasi 2x untuk loop mulus --}}
                    <ul class="partners-track flex items-stretch gap-6 sm:gap-8 w-max">
                        {{-- SET ASLI --}}
                        @foreach ($partners as $partner)
                            <li class="shrink-0 snap-center sm:snap-none">
                                <a href="{{ $partner->website_url ?? '#' }}" target="_blank"
                                    title="{{ $partner->name }}"
                                    class="group relative bg-white rounded-xl ring-1 ring-slate-200 p-4 hover:ring-red-400 hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
                                        class="h-10 sm:h-12 w-auto grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110 transition-transform duration-500 ease-out" />
                                </a>
                            </li>
                        @endforeach

                        {{-- SET DUPLIKAT (aria-hidden agar tidak dibaca screen reader) --}}
                        @foreach ($partners as $partner)
                            <li class="shrink-0 snap-center sm:snap-none" aria-hidden="true">
                                <a href="{{ $partner->website_url ?? '#' }}" target="_blank"
                                    title="{{ $partner->name }}"
                                    class="group relative bg-white rounded-xl ring-1 ring-slate-200 p-4 hover:ring-red-400 hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                                    <img src="{{ Storage::url($partner->logo) }}" alt=""
                                        class="h-10 sm:h-12 w-auto grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110 transition-transform duration-500 ease-out" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- CSS kecil untuk marquee --}}
            <style>
                /* sembunyikan scrollbar di container mobile */
                .no-scrollbar::-webkit-scrollbar {
                    display: none;
                }

                .no-scrollbar {
                    -ms-overflow-style: none;
                    scrollbar-width: none;
                }

                /* fade kiri/kanan */
                .mask-gradient {
                    mask-image: linear-gradient(to right, transparent, black 7%, black 93%, transparent);
                    -webkit-mask-image: linear-gradient(to right, transparent, black 7%, black 93%, transparent);
                }

                /* track jalan otomatis di desktop, pause saat hover */
                .partners-track {
                    animation: partners-marquee 26s linear infinite;
                    will-change: transform;
                }

                @media (hover:hover) {
                    .partners-track:hover {
                        animation-play-state: paused;
                    }
                }

                /* Mobile (< sm): matikan animasi, biar swipe manual */
                @media (max-width: 639.98px) {
                    .partners-track {
                        animation: none;
                    }
                }

                /* gerak ke kiri setengah lebar (karena konten diduplikasi 2x) */
                @keyframes partners-marquee {
                    0% {
                        transform: translateX(0);
                    }

                    100% {
                        transform: translateX(-50%);
                    }
                }
            </style>
        </section>
    @endif

    {{-- SECTION: TESTIMONI ALUMNI --}}
    @if ($testimonials->isNotEmpty())
        <section class="py-16 lg:py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span
                        class="inline-block text-red-800 font-extrabold tracking-widest uppercase text-sm border-b-2 border-red-500 pb-1">
                        Testimoni
                    </span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Apa Kata Alumni?</h2>
                    <p class="mt-2 text-lg text-slate-800">Cerita alumni yang menginspirasi generasi berikutnya.</p>
                </div>

                {{-- 
            // ==========================================================
            // ## PERUBAHAN UTAMA: DARI SWIPER MENJADI GRID 3 KOLOM ##
            // ==========================================================
            --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Kita batasi hanya 3 testimoni yang tampil --}}
                    @foreach ($testimonials->take(3) as $testimonial)
                        {{-- Ini adalah Kartu Testimoni Baru (sesuai gambar) --}}
                        <div
                            class="bg-white p-8 rounded-2xl shadow-lg ring-1 ring-slate-200/70 flex flex-col text-center items-center">

                            {{-- Foto Profil --}}
                            <img class="h-20 w-20 rounded-full object-cover"
                                src="{{ $testimonial->photo ? Storage::url($testimonial->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->name) }}"
                                alt="{{ $testimonial->name }}">

                            {{-- Konten Testimoni --}}
                            <blockquote class="mt-6 flex-grow">
                                <p class="text-slate-700 italic line-clamp-6"> {{-- Dibatasi 6 baris agar rapi --}}
                                    "{{ $testimonial->content }}"
                                </p>
                            </blockquote>

                            {{-- Nama dan Jabatan --}}
                            <figcaption class="mt-6 flex-shrink-0">
                                <div class="font-bold text-slate-900">{{ $testimonial->name }}</div>
                                <div class="text-slate-500 text-sm">
                                    {{ $testimonial->occupation ? $testimonial->occupation . ' - ' : '' }}
                                    Angkatan {{ $testimonial->graduation_year }}
                                </div>
                            </figcaption>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


@endsection

@push('scripts')
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@endpush
