@extends('layouts.admin')
@section('title', 'Manajemen Role')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Role</h1>
        <a href="{{ route('admin.roles.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">+ Tambah Role</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Nama Role</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Izin Akses</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td class="px-5 py-4 border-b font-semibold">{{ $role->name }}</td>
                        <td class="px-5 py-4 border-b">
                            <div class="flex flex-wrap gap-1">
                                @foreach($role->permissions->take(5) as $permission)
                                    <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">{{ $permission->name }}</span>
                                @endforeach
                                @if($role->permissions->count() > 5)
                                    <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">+{{ $role->permissions->count() - 5 }} lagi</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 border-b text-center">
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-indigo-600">Edit Izin</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-10">Belum ada role.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection