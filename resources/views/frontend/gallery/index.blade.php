@extends('layouts.frontend')
@section('title', 'Galeri Foto')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">Galeri Foto</h1>
            <p class="mt-2 text-lg text-slate-600">Dokumentasi kegiatan Universitas dalam gambar.</p>
        </div>

        {{-- GRID FOTO --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($photos as $photo)
                <button type="button"
                    class="group relative overflow-hidden rounded-xl ring-1 ring-slate-200 bg-white hover:ring-red-300 hover:shadow-lg transition"
                    data-src="{{ Storage::url($photo->image_path) }}"
                    data-title="{{ $photo->title ?? 'Galeri Foto' }}">
                    <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title ?? 'Galeri Foto' }}"
                        class="w-full aspect-[4/3] object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div
                        class="absolute inset-x-0 bottom-0 p-2 sm:p-3 bg-gradient-to-t from-black/70 via-black/10 to-transparent">
                        <h3 class="text-white text-sm sm:text-base font-semibold line-clamp-1">
                            {{ $photo->title ?? 'Galeri Foto' }}
                        </h3>
                         @if($photo->album)
                            <p class="text-white/80 text-xs line-clamp-1">{{ $photo->album->title }}</p>
                        @endif
                    </div>
                </button>
            @empty
                <p class="col-span-full text-center py-10 text-slate-500">Belum ada foto di galeri.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $photos->links() }}
        </div>
    </div>

    {{-- MODAL (untuk memperbesar gambar saat diklik) --}}
    <div id="galeriModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/80" data-close></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="relative max-w-5xl w-full">
                <img id="gmImg" src="" alt=""
                    class="w-full max-h-[80vh] object-contain rounded-xl shadow-2xl opacity-0 transition-opacity duration-200" />
                <div class="mt-3 flex items-center justify-between text-white">
                    <p id="gmTitle" class="font-semibold truncate"></p>
                    <button class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 ring-1 ring-white/20"
                        data-close>Close (Esc)</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script untuk fungsi modal --}}
    <script>
        (() => {
            const modal = document.getElementById('galeriModal');
            if (!modal) return;
            
            const img = document.getElementById('gmImg');
            const title = document.getElementById('gmTitle');

            const open = (src, ttl) => {
                img.src = src;
                title.textContent = ttl || '';
                modal.classList.remove('hidden');
                requestAnimationFrame(() => img.classList.remove('opacity-0'));
                document.documentElement.style.overflow = 'hidden';
            };
            const close = () => {
                img.classList.add('opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    img.src = '';
                    title.textContent = '';
                    document.documentElement.style.overflow = '';
                }, 150);
            };

            document.querySelectorAll('[data-src]').forEach(btn => {
                btn.addEventListener('click', () => open(btn.dataset.src, btn.dataset.title));
            });
            modal.addEventListener('click', e => {
                if (e.target.hasAttribute('data-close')) close();
            });
            window.addEventListener('keydown', e => {
                if (!modal.classList.contains('hidden') && e.key === 'Escape') close();
            });
        })();
    </script>
@endpush