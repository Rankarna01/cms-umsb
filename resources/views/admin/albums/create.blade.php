@extends('layouts.admin')
@section('title', 'Buat Album Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Album Baru</h1>
    @include('admin.albums.partials._form')
@endsection