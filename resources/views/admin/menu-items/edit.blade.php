@extends('layouts.admin')
@section('title', 'Edit Item Menu')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Item Menu</h1>
    @include('admin.menu-items._form', ['menuItem' => $menuItem])
@endsection