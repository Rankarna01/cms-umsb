@extends('layouts.admin')
@section('title', 'Atur Izin untuk User')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Atur Izin untuk: <span class="text-blue-600">{{ $user->name }}</span></h1>
    
    <div class="bg-white shadow-md rounded-lg p-8">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        
        <form action="{{ route('admin.users.permissions.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block font-bold mb-2">Izin Akses Menu (Permissions)</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($permissions as $group => $permissionList)
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold capitalize border-b pb-2 mb-2">{{ $group }}</h4>
                            <div class="space-y-2">
                                @foreach($permissionList as $permission)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-checkbox"
                                            {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}
                                        >
                                        <span class="ml-2">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Simpan Izin</button>
                <a href="{{ route('admin.users.index') }}" class="ml-4">Kembali ke Daftar User</a>
            </div>
        </form>
    </div>
@endsection