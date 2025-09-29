@extends('layouts.admin')
@section('title', 'Tambah Item Menu')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Item ke: <span class="text-blue-600">{{ $menu->name }}</span></h1>
    @include('admin.menu-items._form')
@endsection