@extends('layouts.admin')
@section('title', 'Tambah Agenda Baru')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Breadcrumb --}}
  <nav class="flex items-center text-sm text-slate-500 mb-2" aria-label="Breadcrumb">
    <a href="{{ route('admin.events.index') }}" class="hover:text-blue-600 flex items-center gap-1">
      <i class="fa-solid fa-calendar-days"></i> Agenda
    </a>
    <span class="mx-2">/</span>
    <span class="text-slate-700 font-semibold">Tambah Baru</span>
  </nav>

  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Tambah Agenda Baru</h1>
      <p class="text-sm text-slate-500">Isi informasi detail untuk menambahkan agenda ke sistem.</p>
    </div>
  </div>

  {{-- Card Form --}}
  <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
    @include('admin.events.partials._form')
  </div>

  {{-- Tips/Note --}}
  <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-blue-700 text-sm shadow-sm">
    <i class="fa-solid fa-circle-info mr-2"></i>
    Pastikan informasi tanggal, lokasi, dan poster acara diisi dengan benar agar tampil optimal di halaman publik.
  </div>

</div>
@endsection
