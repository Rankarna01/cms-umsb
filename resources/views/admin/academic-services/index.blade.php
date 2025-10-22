@extends('layouts.admin')
@section('title', 'Manajemen Layanan Akademik')

@section('content')
<div class="flex justify-between items-center mb-6">
<h1 class="text-3xl font-bold">Manajemen Layanan Akademik</h1>
<a href="{{ route('admin.academic-services.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
+ Tambah Layanan
</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4" role="alert">
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Ikon</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Judul Layanan</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Deskripsi</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $service)
                <tr>
                    <td class="px-5 py-4 border-b">
                        @if($service->image)
                            <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="h-12 w-12 rounded-full object-cover">
                        @endif
                    </td>
                    <td class="px-5 py-4 border-b">
                        <p class="font-semibold">{{ $service->title }}</p>
                    </td>
                    <td class="px-5 py-4 border-b">
                        <p class="text-sm text-gray-600">{{ $service->description }}</p>
                    </td>
                    <td class="px-5 py-4 border-b text-center whitespace-nowrap">
                        <a href="{{ route('admin.academic-services.edit', $service->id) }}" class="text-indigo-600">Edit</a>
                        <form action="{{ route('admin.academic-services.destroy', $service->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-10 text-gray-500">Belum ada data layanan akademik.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>


@endsection