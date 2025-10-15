@extends('layouts.admin')
@section('title', 'Kategori Galeri')
@section('content')
    <h1 class="text-3xl font-bold">Kategori Galeri</h1>
    {{-- Form tambah ada di sini untuk simpel --}}
    <form action="{{ route('admin.albums.store') }}" method="POST" class="my-6 flex gap-2">
        @csrf
        <input type="text" name="title" placeholder="Nama Kategori Baru" class="shadow border rounded w-full py-2 px-3" required>
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Simpan</button>
    </form>
    @if(session('success'))<div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>@endif
    <div class="bg-white shadow-md rounded-lg">
        <table class="min-w-full">
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b"><td class="p-4 font-semibold">{{ $category->title }}</td><td class="p-4 text-right"><form action="{{ route('admin.albums.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 text-sm">Hapus</button></form></td></tr>
                @empty
                    <tr><td class="p-4 text-center text-gray-500">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection