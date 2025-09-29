<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($factoid) ? route('admin.factoids.update', $factoid->id) : route('admin.factoids.store') }}" method="POST">
        @csrf
        @if(isset($factoid))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="label" class="block font-bold mb-2">Label</label>
            <input type="text" name="label" id="label" value="{{ old('label', $factoid->label ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="Contoh: Jumlah Mahasiswa">
        </div>
        
        <div class="mb-4">
            <label for="value" class="block font-bold mb-2">Nilai / Angka</label>
            <input type="text" name="value" id="value" value="{{ old('value', $factoid->value ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="Contoh: 5120">
        </div>

        <div class="mb-4">
            <label for="icon" class="block font-bold mb-2">Ikon (dari Font Awesome)</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $factoid->icon ?? '') }}" class="shadow border rounded w-full py-2 px-3" placeholder="Contoh: fa-solid fa-users">
            <p class="text-xs text-gray-600 mt-1">Kunjungi <a href="https://fontawesome.com/search" target="_blank" class="text-blue-500">Font Awesome</a> untuk mencari ikon. Salin kelasnya, misal `fa-solid fa-users`.</p>
        </div>

        <div class="mb-6">
            <label for="sort_order" class="block font-bold mb-2">Urutan Tampil</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $factoid->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3">
        </div>

        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($factoid) ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('admin.factoids.index') }}" class="ml-4">Batal</a>
        </div>
    </form>
</div>