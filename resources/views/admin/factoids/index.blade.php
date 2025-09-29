@extends('layouts.admin')
@section('title', 'Manajemen Fakta Kampus')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Fakta Kampus</h1>
        <a href="{{ route('admin.factoids.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
            + Tambah Fakta
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Ikon</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Label</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Nilai/Angka</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($factoids as $factoid)
                    <tr>
                        <td class="px-5 py-4 border-b text-center text-2xl">
                            <i class="{{ $factoid->icon ?? 'fa-solid fa-question-circle' }} text-gray-500"></i>
                        </td>
                        <td class="px-5 py-4 border-b">
                            <p class="font-semibold">{{ $factoid->label }}</p>
                        </td>
                        <td class="px-5 py-4 border-b">
                            <p class="font-bold text-lg">{{ $factoid->value }}</p>
                        </td>
                        <td class="px-5 py-4 border-b text-center">
                            <a href="{{ route('admin.factoids.edit', $factoid->id) }}" class="text-indigo-600">Edit</a>
                            <form action="{{ route('admin.factoids.destroy', $factoid->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10">Belum ada data fakta.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection