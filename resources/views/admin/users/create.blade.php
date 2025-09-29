@extends('layouts.admin')
@section('title', 'Tambah User Baru')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah User Baru</h1>
    @include('admin.users.partials._form')
@endsection