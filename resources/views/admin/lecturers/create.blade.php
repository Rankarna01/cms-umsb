@extends('layouts.admin')
@section('title', 'Tambah Data Dosen')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Data Dosen Baru</h1>
    @include('admin.lecturers.partials._form')
@endsection