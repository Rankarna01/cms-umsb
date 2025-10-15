@extends('layouts.admin')
@section('title', 'Tambah Link Cepat Baru')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah Link Cepat Baru</h1>

    {{-- Kode ini memanggil form dari file lain agar bisa dipakai ulang --}}
    @include('admin.quick-links.partials._form')
@endsection