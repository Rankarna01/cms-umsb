@extends('layouts.admin')
@section('title', 'Edit Testimoni')

@section('content')
<h1 class="text-3xl font-bold mb-6">Edit Testimoni</h1>
@include('admin.testimonials.partials._form', ['testimonial' => $testimonial])
@endsection