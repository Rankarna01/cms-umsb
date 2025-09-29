@extends('layouts.admin')
@section('title', 'Edit Kategori Dokumen')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Kategori Dokumen</h1>
    @include('admin.document-categories.partials._form', ['documentCategory' => $documentCategory])
@endsection