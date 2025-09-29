@extends('layouts.admin')
@section('title', 'Tambah Fakta Baru')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah Fakta Baru</h1>
    @include('admin.factoids.partials._form')
@endsection