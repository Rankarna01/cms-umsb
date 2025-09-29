@extends('layouts.admin')
@section('title', 'Edit Fakta')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Fakta</h1>
    @include('admin.factoids.partials._form', ['factoid' => $factoid])
@endsection