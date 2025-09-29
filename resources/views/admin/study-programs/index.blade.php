@extends('layouts.admin')
@section('title', 'Manajemen Program Studi')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Manajemen Program Studi</h1>
      <p class="text-sm text-slate-500">Kelola daftar program studi per fakultas.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="progSearch" type="text" placeholder="Cari prodi atau fakultas…"
               class="peer w-56 sm:w-72 rounded-xl border border-slate-200 bg-white/80 px-10 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
               oninput="filterProgTable()" />
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
      </div>

      <a href="{{ route('admin.study-programs.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-plus"></i>
        Tambah Prodi
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
      <table id="progTable" class="min-w-full table-auto">
        <thead class="bg-slate-50 sticky top-0 z-10">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Nama Prodi</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Fakultas</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Status</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($studyPrograms as $program)
            <tr class="hover:bg-slate-50/60 transition">
              {{-- Nama Prodi --}}
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <span class="inline-grid h-10 w-10 place-items-center rounded-xl bg-fuchsia-50 text-fuchsia-600">
                    <i class="fa-solid fa-graduation-cap"></i>
                  </span>
                  <div>
                    <p class="font-semibold text-slate-800">{{ $program->name }}</p>
                    <p class="text-xs text-slate-500">ID: {{ $program->id }}</p>
                  </div>
                </div>
              </td>

              {{-- Fakultas --}}
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                  <i class="fa-solid fa-school text-blue-500"></i>
                  {{ $program->faculty->name }}
                </span>
              </td>

              {{-- Status --}}
              <td class="px-5 py-4 text-center">
                @if($program->active)
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
                  <a href="{{ route('admin.study-programs.edit', $program->id) }}"
                     class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm focus:outline-none focus:ring-4 focus:ring-indigo-100"
                     title="Edit">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <form action="{{ route('admin.study-programs.destroy', $program->id) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus prodi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 hover:shadow-sm focus:outline-none focus:ring-4 focus:ring-rose-100"
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
                  <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-xl bg-fuchsia-100 text-fuchsia-600">
                    <i class="fa-solid fa-graduation-cap"></i>
                  </div>
                  <p class="font-semibold text-slate-700">Belum ada data program studi</p>
                  <p class="text-sm text-slate-500">Tambahkan data pertama Anda untuk mulai mengelola.</p>
                  <a href="{{ route('admin.study-programs.create') }}"
                     class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i> Tambah Prodi
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
  function filterProgTable(){
    const q = (document.getElementById('progSearch').value || '').toLowerCase();
    const rows = document.querySelectorAll('#progTable tbody tr');
    rows.forEach(row=>{
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
