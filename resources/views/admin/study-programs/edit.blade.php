@extends('layouts.admin')
@section('title', 'Edit Program Studi')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Program Studi</h1>
    @include('admin.study-programs.partials._form', ['studyProgram' => $studyProgram])
@endsection