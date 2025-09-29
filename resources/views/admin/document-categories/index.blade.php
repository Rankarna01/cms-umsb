@extends('layouts.admin')
@section('title', 'Kategori Dokumen')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kategori Dokumen</h1>
        <a href="{{ route('admin.document-categories.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
            + Tambah Kategori
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
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Nama Kategori</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-5 py-4 border-b">
                            <p class="font-semibold">{{ $category->name }}</p>
                        </td>
                        <td class="px-5 py-4 border-b text-center">
                            <a href="{{ route('admin.document-categories.edit', $category->id) }}" class="text-indigo-600">Edit</a>
                            <form action="{{ route('admin.document-categories.destroy', $category->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-10">Belum ada kategori dokumen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection