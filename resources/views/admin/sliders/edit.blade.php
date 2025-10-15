@extends('layouts.admin')
@section('title', 'Edit Slide')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Slide</h1>
    @include('admin.sliders.partials._form', ['slider' => $slider])
@endsection 