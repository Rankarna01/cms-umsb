@extends('layouts.admin')
@section('title', 'Edit Link Cepat')

@section('content')
<h1 class="text-3xl font-bold mb-6">Edit Link Cepat</h1>

{{-- Kode ini memanggil form yang sama dengan halaman 'create', 
     tapi mengirimkan data '$quickLink' agar form-nya terisi --}}
@include('admin.quick-links.partials._form', ['quickLink' => $quickLink])


@endsectionxamp