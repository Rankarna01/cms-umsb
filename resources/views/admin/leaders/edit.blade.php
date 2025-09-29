@extends('layouts.admin')
@section('title', 'Edit Pimpinan')
@section('content')<h1 class="text-3xl font-bold mb-6">Edit Pimpinan</h1>@include('admin.leaders.partials._form', ['leader' => $leader])@endsection