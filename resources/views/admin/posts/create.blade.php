@extends('layouts.admin')
@section('title', 'Tambah Berita Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Berita Baru</h1>
    @include('admin.posts.partials._form') 
@endsection