@extends('layouts.admin')
@section('title', 'Manajemen Link Cepat')

@section('content')
<div class="flex justify-between items-center mb-6">
<h1 class="text-3xl font-bold">Manajemen Link Cepat</h1>
<a href="{{ route('admin.quick-links.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
+ Tambah Link
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
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Judul</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">URL</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quickLinks as $link)
                <tr>
                    <td class="px-5 py-4 border-b text-center text-2xl">
                        <i class="{{ $link->icon }} text-red-600"></i>
                    </td>
                    <td class="px-5 py-4 border-b font-semibold">{{ $link->title }}</td>
                    <td class="px-5 py-4 border-b text-sm text-gray-600">{{ $link->url }}</td>
                    <td class="px-5 py-4 border-b text-center">
                        <a href="{{ route('admin.quick-links.edit', $link->id) }}" class="text-indigo-600">Edit</a>
                        <form action="{{ route('admin.quick-links.destroy', $link->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-10">Belum ada link cepat.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection