@extends('layouts.admin')
@section('title', 'Manajemen Role')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Manajemen Role</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola role dan izin akses pengguna di sistem admin.
                </p>
            </div>

            <a href="{{ route('admin.roles.create') }}"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Tambah Role</span>
            </a>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card utama --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
        {{-- Header kolom --}}
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
            <div class="col-span-3">Nama Role</div>
            <div class="col-span-7">Izin Akses</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>

        @forelse ($roles as $role)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex flex-col md:grid md:grid-cols-12 md:items-center gap-4">
                        {{-- Nama role --}}
                        <div class="md:col-span-3 flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-50 text-red-600 rounded-full flex items-center justify-center ring-2 ring-gray-100">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <p class="font-semibold text-gray-900">{{ $role->name }}</p>
                        </div>

                        {{-- Izin akses --}}
                        <div class="md:col-span-7">
                            <div class="flex flex-wrap gap-1">
                                @foreach($role->permissions->take(5) as $permission)
                                    <span class="bg-gray-100 border border-gray-200 text-gray-700 text-xs font-medium px-2 py-1 rounded-md">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                                @if($role->permissions->count() > 5)
                                    <span class="bg-gray-100 border border-gray-200 text-gray-500 text-xs font-medium px-2 py-1 rounded-md">
                                        +{{ $role->permissions->count() - 5 }} lagi
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="md:col-span-2 flex justify-center md:justify-end">
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                               class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit Izin</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-10 text-center text-gray-500">Belum ada role.</div>
        @endforelse
    </div>
@endsection
