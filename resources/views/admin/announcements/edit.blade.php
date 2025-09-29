@extends('layouts.admin')
@section('title', 'Edit Pengumuman')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Pengumuman</h1>
    @include('admin.announcements.partials._form', ['announcement' => $announcement])
@endsection