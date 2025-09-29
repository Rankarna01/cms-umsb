@extends('layouts.admin')
@section('title', 'Edit Halaman')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Halaman</h1>
    @include('admin.pages.partials._form', ['page' => $page])
@endsection