@extends('layouts.admin')
@section('title', 'Manajemen Pengumuman')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Manajemen Pengumuman</h1>
      <p class="text-sm text-slate-500">Kelola daftar pengumuman, kategori, dan lampiran.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="annSearch" type="text" placeholder="Cari judul/kategori/penulis…"
               class="peer w-56 sm:w-72 rounded-xl border border-slate-200 bg-white/80 px-10 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
               oninput="filterAnnTable()" />
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
      </div>

      <a href="{{ route('admin.announcements.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-plus"></i> Tambah Pengumuman
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
      <table id="annTable" class="min-w-full table-auto">
        <thead class="bg-slate-50 sticky top-0 z-10">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Judul</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Kategori</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Lampiran</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($announcements as $announcement)
            <tr class="hover:bg-slate-50/60 transition">
              {{-- Judul + penulis --}}
              <td class="px-5 py-4">
                <p class="font-semibold text-slate-800">{{ $announcement->title }}</p>
                <p class="text-xs text-slate-500">Oleh: {{ $announcement->author->name }}</p>
              </td>

              {{-- Kategori --}}
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 rounded-lg bg-violet-50 px-2.5 py-1.5 text-xs font-medium text-violet-700">
                  <i class="fa-solid fa-tags text-violet-500"></i>
                  {{ $announcement->category->name ?? '-' }}
                </span>
              </td>

              {{-- Lampiran --}}
              <td class="px-5 py-4">
                @if($announcement->attachment)
                  <a href="{{ Storage::url($announcement->attachment) }}" target="_blank"
                     class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:shadow-sm">
                    <i class="fa-regular fa-file"></i> Lihat File
                  </a>
                @else
                  <span class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                    <i class="fa-regular fa-file"></i> Tidak ada
                  </span>
                @endif
              </td>

              {{-- Aksi --}}
              <td class="px-5 py-4">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                     class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm"
                     title="Edit">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
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
                  <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-xl bg-amber-100 text-amber-600">
                    <i class="fa-solid fa-bullhorn"></i>
                  </div>
                  <p class="font-semibold text-slate-700">Belum ada pengumuman</p>
                  <p class="text-sm text-slate-500">Tambahkan pengumuman baru untuk mulai mengelola.</p>
                  <a href="{{ route('admin.announcements.create') }}"
                     class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i> Tambah Pengumuman
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
  function filterAnnTable(){
    const q = (document.getElementById('annSearch').value || '').toLowerCase();
    const rows = document.querySelectorAll('#annTable tbody tr');
    rows.forEach(row=>{
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
