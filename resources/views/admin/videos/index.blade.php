@extends('layouts.admin')
@section('title', 'Galeri Video')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Galeri Video</h1>
      <p class="text-sm text-slate-500">Kelola koleksi video kampus (YouTube/URL eksternal).</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="videoSearch" type="text" placeholder="Cari judul/keterangan…"
               class="peer w-56 sm:w-72 rounded-xl border border-slate-200 bg-white/80 px-10 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
               oninput="filterVideoCards()" />
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
      </div>

      <a href="{{ route('admin.videos.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-video"></i> Tambah Video
      </a>
    </div>
  </div>

  {{-- Alert sukses --}}
  @if(session('success'))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
      <i class="fa-regular fa-circle-check mr-2"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  {{-- Grid Video --}}
  <div id="videoGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse ($videos as $video)
      <div class="video-card group overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 shadow-sm hover:shadow-md transition">
        <a href="{{ $video->video_url }}" target="_blank" rel="noopener" class="relative block">
          <div class="aspect-video w-full overflow-hidden bg-slate-100">
            @if($video->thumbnail_url)
              <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
                   class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"/>
            @else
              <div class="flex h-full w-full items-center justify-center text-slate-400">
                <i class="fa-regular fa-circle-play text-4xl"></i>
              </div>
            @endif
          </div>

          {{-- Overlay tombol Play --}}
          <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
            <span class="pointer-events-auto inline-grid h-12 w-12 place-items-center rounded-full bg-white/90 text-blue-600 shadow transition group-hover:scale-110">
              <i class="fa-solid fa-play"></i>
            </span>
          </div>

          {{-- Overlay badge sumber --}}
          <div class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-black/50 px-2.5 py-1 text-xs font-medium text-white backdrop-blur-sm">
            <i class="fa-brands fa-youtube"></i> Video
          </div>
        </a>

        <div class="p-4">
          <h3 class="font-semibold text-slate-800 truncate" title="{{ $video->title }}">{{ $video->title }}</h3>
          <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $video->caption ?? '' }}</p>

          <div class="mt-4 flex items-center justify-end gap-2">
            <a href="{{ route('admin.videos.edit', $video->id) }}"
               class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm">
              <i class="fa-regular fa-pen-to-square"></i> Edit
            </a>

            <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST"
                  onsubmit="return confirm('Yakin?');" class="inline">
              @csrf @method('DELETE')
              <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 hover:shadow-sm">
                <i class="fa-regular fa-trash-can"></i> Hapus
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="col-span-4 text-center text-slate-500">
        Belum ada video. <a href="{{ route('admin.videos.create') }}" class="text-blue-600 hover:underline">Tambah video pertama</a>.
      </p>
    @endforelse
  </div>
</div>

<script>
  // Filter client-side (tanpa ubah backend)
  function filterVideoCards(){
    const q = (document.getElementById('videoSearch').value || '').toLowerCase();
    document.querySelectorAll('#videoGrid .video-card').forEach(card=>{
      const text = card.innerText.toLowerCase();
      card.style.display = text.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
