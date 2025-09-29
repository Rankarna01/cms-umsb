@extends('layouts.admin')
@section('title', 'Edit Role')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Role: {{ $role->name }}</h1>
    @include('admin.roles.partials._form', ['role' => $role])
@endsection