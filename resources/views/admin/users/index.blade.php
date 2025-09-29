@extends('layouts.admin')
@section('title', 'Manajemen User')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen User</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
            + Tambah User
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
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Nama</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Role</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="px-5 py-4 border-b">
                            <p class="font-semibold">{{ $user->name }}</p>
                            <p class="text-xs text-gray-600">{{ $user->email }}</p>
                        </td>
                        <td class="px-5 py-4 border-b">
                            @foreach($user->getRoleNames() as $role)
                                <span class="bg-blue-200 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td class="px-5 py-4 border-b text-center whitespace-nowrap">
                            {{-- TOMBOL BARU UNTUK ATUR IZIN --}}
                            <a href="{{ route('admin.users.permissions.edit', $user->id) }}" class="bg-green-500 text-white px-3 py-1 rounded text-sm font-semibold">Atur Izin</a>
                            
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 ml-4">Edit Data</a>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-10">Belum ada data user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection