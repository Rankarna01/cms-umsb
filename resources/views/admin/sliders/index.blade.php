@extends('layouts.admin')
@section('title', 'Daftar Slider')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Slider</h1>
      <p class="text-sm text-slate-500">Kelola gambar slider beranda dan urutannya.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="slideSearch" type="text" placeholder="Cari judul atau status…"
               class="peer w-56 sm:w-72 rounded-xl border border-slate-200 bg-white/80 px-10 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
               oninput="filterSlideTable()" />
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
      </div>

      <a href="{{ route('admin.sliders.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-plus"></i> Tambah
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
      <table id="slideTable" class="min-w-full table-auto">
        <thead class="bg-slate-50 sticky top-0 z-10">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">#</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Gambar</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Judul</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Urutan</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aktif</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($slides as $i => $slide)
            <tr class="hover:bg-slate-50/60 transition">
              {{-- # --}}
              <td class="px-5 py-4">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">
                  {{ $i+1 }}
                </span>
              </td>

              {{-- Gambar --}}
              <td class="px-5 py-4">
                <div class="w-28 h-16 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center shadow-sm">
                  @if($slide->image)
                    <img src="{{ Storage::url($slide->image) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                  @else
                    <i class="fa-regular fa-image text-slate-400 text-xl"></i>
                  @endif
                </div>
              </td>

              {{-- Judul --}}
              <td class="px-5 py-4">
                <p class="font-semibold text-slate-800">{{ $slide->title }}</p>
                @if(!empty($slide->subtitle))
                  <p class="text-xs text-slate-500">{{ $slide->subtitle }}</p>
                @endif
              </td>

              {{-- Urutan --}}
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 rounded-lg bg-amber-50 px-2.5 py-1.5 text-xs font-medium text-amber-700">
                  <i class="fa-solid fa-arrow-up-9-1"></i> {{ $slide->sort_order }}
                </span>
              </td>

              {{-- Aktif --}}
              <td class="px-5 py-4">
                @if($slide->active)
                  <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    <i class="fa-solid fa-circle-check"></i> Y
                  </span>
                @else
                  <span class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                    <i class="fa-solid fa-circle-xmark"></i> N
                  </span>
                @endif
              </td>

              {{-- Aksi --}}
              <td class="px-5 py-4">
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.sliders.edit', $slide) }}"
                     class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <form action="{{ route('admin.sliders.destroy', $slide) }}" method="POST" class="inline"
                        onsubmit="return confirm('Hapus slide ini?')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 hover:shadow-sm">
                      <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-16">
                <div class="mx-auto w-full max-w-md rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
                  <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-xl bg-slate-100 text-slate-500">
                    <i class="fa-regular fa-images text-xl"></i>
                  </div>
                  <p class="font-semibold text-slate-700">Belum ada data</p>
                  <p class="text-sm text-slate-500">Tambahkan gambar slider untuk mulai menampilkan di beranda.</p>
                  <a href="{{ route('admin.sliders.create') }}"
                     class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i> Tambah
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
  function filterSlideTable(){
    const q = (document.getElementById('slideSearch').value || '').toLowerCase();
    const rows = document.querySelectorAll('#slideTable tbody tr');
    rows.forEach(row=>{
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
