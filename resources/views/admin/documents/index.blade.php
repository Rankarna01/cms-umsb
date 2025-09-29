@extends('layouts.admin')
@section('title', 'Manajemen Dokumen')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Manajemen Dokumen</h1>
      <p class="text-sm text-slate-500">Kelola file dokumen dan kategorinya.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="docSearch" type="text" placeholder="Cari judul/kategori/penulis…"
               class="peer w-56 sm:w-72 rounded-xl border border-slate-200 bg-white/80 px-10 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
               oninput="filterDocTable()" />
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
      </div>

      <a href="{{ route('admin.documents.create') }}"
         class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-upload"></i> Upload Dokumen
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
      <table id="docTable" class="min-w-full table-auto">
        <thead class="bg-slate-50 sticky top-0 z-10">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Judul</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Kategori</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($documents as $document)
            <tr class="hover:bg-slate-50/60 transition">
              {{-- Judul + Author + ikon tipe --}}
              <td class="px-5 py-4">
                <div class="flex items-start gap-3">
                  <span class="mt-0.5 inline-grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-slate-600">
                    {{-- Ikon tipe file sederhana berdasarkan ekstensi --}}
                    @php
                      $ext = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                      $icon = 'fa-file';
                      $tone = 'text-slate-600';
                      if(in_array($ext, ['pdf'])) { $icon='fa-file-pdf'; $tone='text-rose-600'; }
                      elseif(in_array($ext, ['doc','docx'])) { $icon='fa-file-word'; $tone='text-blue-600'; }
                      elseif(in_array($ext, ['xls','xlsx','csv'])) { $icon='fa-file-excel'; $tone='text-emerald-600'; }
                      elseif(in_array($ext, ['ppt','pptx'])) { $icon='fa-file-powerpoint'; $tone='text-orange-500'; }
                      elseif(in_array($ext, ['jpg','jpeg','png','gif','webp'])) { $icon='fa-file-image'; $tone='text-indigo-600'; }
                      elseif(in_array($ext, ['zip','rar','7z'])) { $icon='fa-file-zipper'; $tone='text-amber-600'; }
                    @endphp
                    <i class="fa-regular {{ $icon }} {{ $tone }}"></i>
                  </span>
                  <div>
                    <p class="font-semibold text-slate-800">{{ $document->title }}</p>
                    <p class="text-xs text-slate-500">Oleh: {{ $document->author->name }}</p>
                  </div>
                </div>
              </td>

              {{-- Kategori --}}
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 rounded-lg bg-violet-50 px-2.5 py-1.5 text-xs font-medium text-violet-700">
                  <i class="fa-solid fa-folder-tree text-violet-500"></i>
                  {{ $document->category->name }}
                </span>
              </td>

              {{-- Aksi --}}
              <td class="px-5 py-4">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                     class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 hover:shadow-sm">
                    <i class="fa-solid fa-download"></i> Unduh
                  </a>

                  <a href="{{ route('admin.documents.edit', $document->id) }}"
                     class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('Yakin?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                      class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 hover:shadow-sm">
                      <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="py-16">
                <div class="mx-auto w-full max-w-md rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
                  <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-xl bg-slate-100 text-slate-500">
                    <i class="fa-regular fa-file-lines text-xl"></i>
                  </div>
                  <p class="font-semibold text-slate-700">Belum ada dokumen</p>
                  <p class="text-sm text-slate-500">Unggah dokumen baru untuk mulai mengelola.</p>
                  <a href="{{ route('admin.documents.create') }}"
                     class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700">
                    <i class="fa-solid fa-upload"></i> Upload Dokumen
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
  function filterDocTable(){
    const q = (document.getElementById('docSearch').value || '').toLowerCase();
    const rows = document.querySelectorAll('#docTable tbody tr');
    rows.forEach(row=>{
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
