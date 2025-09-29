@extends('layouts.admin')
@section('title', 'Edit Agenda')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Agenda</h1>
    @include('admin.events.partials._form', ['event' => $event])
@endsection