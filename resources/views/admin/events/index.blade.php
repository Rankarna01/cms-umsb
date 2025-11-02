@extends('layouts.admin')
@section('title', 'Manajemen Agenda')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Manajemen Agenda</h1>
      <p class="text-sm text-slate-500">Kelola daftar acara, lokasi, dan waktu pelaksanaan.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="eventSearch" type="text" placeholder="Cari judul/lokasi/penyelenggara…"
               class="peer w-56 sm:w-72 rounded-xl border border-slate-200 bg-white/80 px-10 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
               oninput="filterEventTable()" />
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
      </div>

      <a href="{{ route('admin.events.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-red-500 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-calendar-plus"></i> Tambah Agenda
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

  {{-- Table --}}
  <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 shadow-sm">
    <div class="overflow-x-auto">
      <table id="eventTable" class="min-w-full table-auto">
        <thead class="bg-slate-50 sticky top-0 z-10">
          <tr>
            {{-- <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Poster</th> --}}
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Judul Acara</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Waktu & Tempat</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($events as $event)
            <tr class="hover:bg-slate-50/60 transition">
              {{-- Poster --}}
              {{-- <td class="px-5 py-4">
                <div class="w-28 h-20 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center shadow-sm">
                  @if($event->poster)
                    <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                  @else
                    <i class="fa-regular fa-image text-slate-400 text-xl"></i>
                  @endif
                </div>
              </td> --}}

              {{-- Judul + author --}}
              <td class="px-5 py-4">
                <p class="font-semibold text-slate-800">{{ $event->title }}</p>
                <p class="text-xs text-slate-500">Oleh: {{ $event->author->name }}</p>
              </td>

              {{-- Waktu & Tempat + badge status waktu --}}
              <td class="px-5 py-4">
                <div class="flex items-start gap-3">
                  <span class="mt-1 inline-grid h-9 w-9 place-items-center rounded-lg bg-blue-50 text-blue-600">
                    <i class="fa-regular fa-calendar-days"></i>
                  </span>
                  <div>
                    <p class="text-slate-800">
                      {{ $event->start_date->format('d M Y, H:i') }}
                      @php $isPast = \Carbon\Carbon::now()->gt($event->start_date); @endphp
                      @if($isPast)
                        <span class="ml-2 inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-semibold text-slate-600">
                          <i class="fa-regular fa-clock"></i> Past
                        </span>
                      @else
                        <span class="ml-2 inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700">
                          <i class="fa-solid fa-bolt"></i> Upcoming
                        </span>
                      @endif
                    </p>
                    <p class="text-xs text-slate-500 mt-1">
                      <i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}
                    </p>
                  </div>
                </div>
              </td>

              {{-- Aksi --}}
              <td class="px-5 py-4">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('admin.events.edit', $event->id) }}"
                     class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm"
                     title="Edit">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus agenda ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 hover:shadow-sm"
                      title="Hapus">
                      <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-16">
                <div class="mx-auto w-full max-w-md rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
                  <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-xl bg-blue-100 text-blue-600">
                    <i class="fa-regular fa-calendar"></i>
                  </div>
                  <p class="font-semibold text-slate-700">Belum ada agenda</p>
                  <p class="text-sm text-slate-500">Tambahkan agenda baru untuk mulai mengelola acara.</p>
                  <a href="{{ route('admin.events.create') }}"
                     class="mt-4 inline-flex items-center gap-2 rounded-lg bg-red-500 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-red-700">
                    <i class="fa-solid fa-calendar-plus"></i> Tambah Agenda
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  // Filter client-side (tanpa ubah backend)
  function filterEventTable(){
    const q = (document.getElementById('eventSearch').value || '').toLowerCase();
    const rows = document.querySelectorAll('#eventTable tbody tr');
    rows.forEach(row=>{
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
