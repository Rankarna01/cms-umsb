@extends('layouts.admin')
@section('title', 'Tambah Pengumuman Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Pengumuman Baru</h1>
    @include('admin.announcements.partials._form')
@endsection