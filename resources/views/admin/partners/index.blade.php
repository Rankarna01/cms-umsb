@extends('layouts.admin')
@section('title', 'Kerja Sama & Media')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kerja Sama & Media</h1>
        <a href="{{ route('admin.partners.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">+ Tambah Partner</a>
    </div>
    @if(session('success'))<div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>@endif
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead><tr><th class="px-5 py-3 border-b-2 bg-gray-100">Logo</th><th class="px-5 py-3 border-b-2 bg-gray-100 text-left">Nama Instansi/Media</th><th class="px-5 py-3 border-b-2 bg-gray-100 text-left">Tipe</th><th class="px-5 py-3 border-b-2 bg-gray-100 text-center">Aksi</th></tr></thead>
            <tbody>
                @forelse ($partners as $partner)
                    <tr>
                        <td class="px-5 py-4 border-b"><img src="{{ $partner->logo ? Storage::url($partner->logo) : 'https://via.placeholder.com/150x50' }}" alt="{{ $partner->name }}" class="h-10 w-auto"></td>
                        <td class="px-5 py-4 border-b font-semibold">{{ $partner->name }}</td>
                        <td class="px-5 py-4 border-b capitalize">{{ $partner->type }}</td>
                        <td class="px-5 py-4 border-b text-center"><a href="{{ route('admin.partners.edit', $partner->id) }}" class="text-indigo-600">Edit</a><form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600">Hapus</button></form></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-10">Belum ada data partner.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection