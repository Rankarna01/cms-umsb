@extends('layouts.admin')
@section('title', 'Manajemen Menu')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Menu</h1>
    <div class="bg-white shadow-md rounded-lg p-8">
        <p class="mb-4 text-gray-600">Pilih menu yang ingin Anda kelola item-item di dalamnya.</p>
        <div class="space-y-4">
            @foreach($menus as $menu)
                <div class="flex justify-between items-center p-4 border rounded-lg">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $menu->name }}</h3>
                        <span class="text-sm text-gray-500">Lokasi: {{ $menu->location }}</span>
                    </div>
                    <a href="{{ route('admin.menus.show', $menu->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Kelola Menu
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection