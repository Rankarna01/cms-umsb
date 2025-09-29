@extends('layouts.admin')
@section('title', 'Tambah Kategori Dokumen')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah Kategori Dokumen Baru</h1>
    @include('admin.document-categories.partials._form')
@endsection