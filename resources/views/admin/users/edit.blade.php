@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit User</h1>
    @include('admin.users.partials._form', ['user' => $user])
@endsection