@extends('layouts.admin')
@section('title', 'Manajemen Berita')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Manajemen Berita</h1>
      <p class="text-sm text-slate-500">Kelola berita, kategori, dan status publikasi.</p>
    </div>
    <a href="{{ route('admin.posts.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-red-500 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
      <i class="fa-solid fa-circle-plus"></i> Tambah Berita
    </a>
  </div>

  {{-- Alert sukses --}}
  @if (session('success'))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
      <i class="fa-regular fa-circle-check mr-2"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  {{-- Tabel --}}
  <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 shadow-sm">
    <div class="overflow-x-auto">
      <table class="min-w-full table-auto">
        <thead class="bg-slate-50 sticky top-0 z-10">
          <tr>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Thumbnail</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Judul</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Kategori</th>
            <th class="px-5 py-3 text-left text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Status</th>
            <th class="px-5 py-3 text-center text-[11px] font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($posts as $post)
            <tr class="hover:bg-slate-50/60 transition">
              {{-- Thumbnail --}}
              <td class="px-5 py-4">
                <div class="w-24 h-16 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center shadow-sm">
                  @if ($post->thumbnail)
                    <img src="{{ Storage::url($post->thumbnail) }}" alt="Thumbnail"
                         class="w-full h-full object-cover" />
                  @else
                    <i class="fa-regular fa-image text-slate-400 text-xl"></i>
                  @endif
                </div>
              </td>

              {{-- Judul + Author --}}
              <td class="px-5 py-4">
                <p class="font-semibold text-slate-800">{{ $post->title }}</p>
                <p class="text-xs text-slate-500">by {{ $post->author->name }}</p>
              </td>

              {{-- Kategori --}}
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700">
                  <i class="fa-solid fa-tags text-violet-500"></i>
                  {{ $post->category->name }}
                </span>
              </td>

              {{-- Status --}}
              <td class="px-5 py-4">
                @if ($post->status == 'published')
                  <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">
                    <i class="fa-solid fa-check-circle"></i> Published
                  </span>
                @else
                  <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                    <i class="fa-solid fa-clock"></i> Draft
                  </span>
                @endif
              </td>

              {{-- Aksi --}}
              <td class="px-5 py-4 text-center">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('admin.posts.edit', $post->id) }}"
                     class="inline-flex items-center gap-1 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 hover:shadow-sm">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>
                  <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 hover:shadow-sm">
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
                  <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-xl bg-slate-100 text-slate-400">
                    <i class="fa-regular fa-newspaper text-xl"></i>
                  </div>
                  <p class="font-semibold text-slate-700">Tidak ada data berita</p>
                  <p class="text-sm text-slate-500">Tambahkan berita baru untuk mulai mengelola konten.</p>
                  <a href="{{ route('admin.posts.create') }}"
                     class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Berita
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
@endsection
