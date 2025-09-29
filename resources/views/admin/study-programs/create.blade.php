@extends('layouts.admin')
@section('title', 'Tambah Prodi Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Program Studi Baru</h1>
    @include('admin.study-programs.partials._form')
@endsection