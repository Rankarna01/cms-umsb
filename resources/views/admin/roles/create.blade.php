@extends('layouts.admin')
@section('title', 'Buat Role Baru')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Buat Role Baru</h1>
    @include('admin.roles.partials._form')
@endsection