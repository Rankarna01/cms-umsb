@extends('layouts.admin')
@section('title', 'Edit Video')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Video</h1>
    @include('admin.videos.partials._form', ['video' => $video])
@endsection