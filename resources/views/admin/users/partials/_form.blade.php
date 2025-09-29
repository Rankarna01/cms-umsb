<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block font-bold mb-2">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block font-bold mb-2">Password</label>
            <input type="password" name="password" id="password" class="shadow border rounded w-full py-2 px-3" {{ isset($user) ? '' : 'required' }}>
             @if (isset($user)) <p class="text-xs text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah password.</p> @endif
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block font-bold mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow border rounded w-full py-2 px-3">
        </div>
       

        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($user) ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('admin.users.index') }}" class="ml-4">Batal</a>
        </div>
    </form>
</div>