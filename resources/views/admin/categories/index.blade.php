@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Manajemen Kategori Berita</h1>
      <p class="text-sm text-slate-500">Kelola kategori untuk pengelompokan berita.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="catSearch" type="text" placeholder="Cari nama/slug/tipe…"
               class="peer w-56 sm:w-72 rounded-xl border border-slate-200 bg-white/80 px-10 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
               oninput="filterCatTable()" />
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
      </div>

      {{-- Arahkan ke route create --}}
      <a href="{{ route('admin.categories.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
      </a>
    </div>
  </div>

  {{-- Alert sukses --}}
  @if (session('success'))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
      <i class="fa-regular fa-circle-check mr-2"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  {{-- Table --}}
  <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 shadow-sm">
    <div class="overflow-x-auto">
      <table id="catTable" class="min-w-full table-auto">
        <thead class="bg-slate-50 sticky top-0 z-10">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Nama</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Slug</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Tipe</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Status</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($categories as $category)
            <tr class="hover:bg-slate-50/60 transition">
              {{-- Nama --}}
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <span class="inline-grid h-10 w-10 place-items-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-tags"></i>
                  </span>
                  <div>
                    <p class="font-semibold text-slate-800">{{ $category->name }}</p>
                    <p class="text-xs text-slate-500">ID: {{ $category->id }}</p>
                  </div>
                </div>
              </td>

              {{-- Slug --}}
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                  <i class="fa-solid fa-link text-slate-500"></i>{{ $category->slug }}
                </span>
              </td>

              {{-- Tipe --}}
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                  <i class="fa-solid fa-layer-group"></i> {{ $category->type }}
                </span>
              </td>

              {{-- Status --}}
              <td class="px-5 py-4 text-center">
                @if ($category->active)
                  <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                    <i class="fa-solid fa-circle-check"></i> Aktif
                  </span>
                @else
                  <span class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700">
                    <i class="fa-solid fa-circle-xmark"></i> Non-Aktif
                  </span>
                @endif
              </td>

              {{-- Aksi --}}
              <td class="px-5 py-4">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('admin.categories.edit', $category->id) }}"
                     class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm"
                     title="Edit">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  {{-- Form hapus --}}
                  <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
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
              <td colspan="5" class="py-16">
                <div class="mx-auto w-full max-w-md rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
                  <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-xl bg-indigo-100 text-indigo-600">
                    <i class="fa-solid fa-box-archive"></i>
                  </div>
                  <p class="font-semibold text-slate-700">Tidak ada data kategori</p>
                  <p class="text-sm text-slate-500">Tambahkan kategori baru untuk mulai mengelola.</p>
                  <a href="{{ route('admin.categories.create') }}"
                     class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i> Tambah Kategori
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
  // Filter client-side sederhana (tanpa ubah backend)
  function filterCatTable(){
    const q = (document.getElementById('catSearch').value || '').toLowerCase();
    const rows = document.querySelectorAll('#catTable tbody tr');
    rows.forEach(row=>{
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
