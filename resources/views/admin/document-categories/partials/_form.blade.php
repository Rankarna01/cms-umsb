<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($documentCategory) ? route('admin.document-categories.update', $documentCategory->id) : route('admin.document-categories.store') }}" method="POST">
        @csrf
        @if(isset($documentCategory))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block font-bold mb-2">Nama Kategori</label>
            <input type="text" name="name" id="name" value="{{ old('name', $documentCategory->name ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>

        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($documentCategory) ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('admin.document-categories.index') }}" class="ml-4">Batal</a>
        </div>
    </form>
</div>