@extends('layouts.admin')
@section('title', 'Tambah Video Baru')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah Video Baru</h1>
    @include('admin.videos.partials._form')
@endsection