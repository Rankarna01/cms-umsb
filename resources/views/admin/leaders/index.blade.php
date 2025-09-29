@extends('layouts.admin')
@section('title', 'Manajemen Pimpinan')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Pimpinan</h1>
        <a href="{{ route('admin.leaders.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">+ Tambah Pimpinan</a>
    </div>
    @if(session('success'))<div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>@endif
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead><tr><th class="px-5 py-3 border-b-2 bg-gray-100">Foto</th><th class="px-5 py-3 border-b-2 bg-gray-100 text-left">Nama</th><th class="px-5 py-3 border-b-2 bg-gray-100 text-left">Jabatan</th><th class="px-5 py-3 border-b-2 bg-gray-100 text-center">Aksi</th></tr></thead>
            <tbody>
                @forelse ($leaders as $leader)
                    <tr>
                        <td class="px-5 py-4 border-b"><img src="{{ $leader->photo ? Storage::url($leader->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($leader->name) }}" alt="{{ $leader->name }}" class="h-16 w-16 rounded-full object-cover"></td>
                        <td class="px-5 py-4 border-b font-semibold">{{ $leader->name }}</td>
                        <td class="px-5 py-4 border-b">{{ $leader->position }}</td>
                        <td class="px-5 py-4 border-b text-center"><a href="{{ route('admin.leaders.edit', $leader->id) }}" class="text-indigo-600">Edit</a><form action="{{ route('admin.leaders.destroy', $leader->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600">Hapus</button></form></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-10">Belum ada data pimpinan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection