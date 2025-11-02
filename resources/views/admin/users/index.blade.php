@extends('layouts.admin')
@section('title', 'Manajemen User')

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Manajemen User</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola akun pengguna, peran, dan izin akses sistem admin.
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah User</span>
            </a>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Card utama --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
        {{-- Header kolom --}}
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
            <div class="col-span-5">Nama & Email</div>
            <div class="col-span-3">Role</div>
            <div class="col-span-4 text-center">Aksi</div>
        </div>

        @forelse ($users as $user)
            <div class="border-t first:border-t-0">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex flex-col md:grid md:grid-cols-12 md:items-center gap-4">
                        {{-- Nama & email --}}
                        <div class="md:col-span-5 flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center ring-2 ring-gray-100">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="md:col-span-3">
                            @foreach($user->getRoleNames() as $role)
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold mr-2 px-2.5 py-1 rounded-full">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Aksi --}}
                        <div class="md:col-span-4 flex justify-center md:justify-end flex-wrap gap-2">
                            {{-- Tombol atur izin --}}
                            <a href="{{ route('admin.users.permissions.edit', $user->id) }}"
                               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium px-3 py-2 rounded-lg shadow-sm">
                                <i class="fa-solid fa-key"></i>
                                <span>Atur Izin</span>
                            </a>

                            {{-- Tombol edit --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="inline-flex items-center gap-2 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 font-medium px-3 py-2 rounded-lg">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>

                            {{-- Tombol hapus --}}
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 border border-red-200 text-red-600 hover:bg-red-50 font-medium px-3 py-2 rounded-lg">
                                    <i class="fa-regular fa-trash-can"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-10 text-center text-gray-500">Belum ada data user.</div>
        @endforelse
    </div>
@endsection
