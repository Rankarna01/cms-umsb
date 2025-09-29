@extends('layouts.admin')
@section('title', 'Edit Dokumen')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Dokumen</h1>
    @include('admin.documents.partials._form', ['document' => $document])
@endsection