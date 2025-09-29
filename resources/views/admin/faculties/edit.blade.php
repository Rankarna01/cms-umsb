@extends('layouts.admin')
@section('title', 'Edit Fakultas')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Fakultas</h1>
    @include('admin.faculties.partials._form', ['faculty' => $faculty])
@endsection