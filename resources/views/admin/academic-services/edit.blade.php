@extends('layouts.admin')
@section('title', 'Edit Layanan Akademik')

@section('content')
<h1 class="text-3xl font-bold mb-6">Edit Layanan Akademik</h1>
@include('admin.academic-services.partials._form', ['academicService' => $academicService])
@endsection