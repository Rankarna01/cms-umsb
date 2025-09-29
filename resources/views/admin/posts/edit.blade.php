@extends('layouts.admin')
@section('title', 'Edit Berita')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Berita</h1>
    @include('admin.posts.partials._form', ['post' => $post])
@endsection