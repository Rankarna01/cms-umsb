@extends('layouts.admin')
@section('title', 'Tambah Fakultas Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Fakultas Baru</h1>
    @include('admin.faculties.partials._form')
@endsection