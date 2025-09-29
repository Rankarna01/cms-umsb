@extends('layouts.admin')
@section('title', 'Edit Data Dosen')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Dosen</h1>
    @include('admin.lecturers.partials._form', ['lecturer' => $lecturer])
@endsection