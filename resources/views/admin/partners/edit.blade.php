@extends('layouts.admin')
@section('title', 'Edit Partner')
@section('content')<h1 class="text-3xl font-bold mb-6">Edit Partner</h1>@include('admin.partners.partials._form', ['partner' => $partner])@endsection