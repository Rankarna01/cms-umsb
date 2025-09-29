<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($faculty) ? route('admin.faculties.update', $faculty->id) : route('admin.faculties.store') }}" method="POST">
        @csrf
        @if(isset($faculty))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Fakultas</label>
            <input type="text" name="name" id="name" value="{{ old('name', $faculty->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $faculty->active ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Aktifkan fakultas ini</span>
            </label>
        </div>

        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ isset($faculty) ? 'Perbarui' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.faculties.index') }}" class="ml-4 text-gray-600">Batal</a>
        </div>
    </form>
</div>