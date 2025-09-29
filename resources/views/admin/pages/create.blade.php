@extends('layouts.admin')
@section('title', 'Tambah Halaman Baru')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Tambah Halaman Baru</h1>
      <p class="text-sm text-slate-500 mt-1">Isi detail halaman statis untuk ditampilkan di situs.</p>
    </div>
    <a href="{{ route('admin.pages.index') }}"
       class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 hover:shadow-md">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
  </div>

  {{-- Card Form --}}
  <div class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-slate-200">
    @include('admin.pages.partials._form')
  </div>
</div>
@endsection
