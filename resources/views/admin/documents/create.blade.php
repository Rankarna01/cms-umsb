@extends('layouts.admin')
@section('title', 'Upload Dokumen Baru')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Upload Dokumen Baru</h1>
    @include('admin.documents.partials._form')
@endsection