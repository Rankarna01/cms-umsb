@extends('layouts.admin')
@section('title', 'Edit Album')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Album</h1>
    @include('admin.albums.partials._form', ['album' => $album])
@endsection