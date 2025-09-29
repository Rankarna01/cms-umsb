@extends('layouts.admin')

@section('title', 'Tambah Slide')

@section('content')
<h1 class="text-3xl font-bold mb-6">Tambah Slide</h1>
@include('admin.sliders.partials._form') {{-- tanpa $slide --}}
@endsection
