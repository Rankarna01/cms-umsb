<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($quickLink) ? route('admin.quick-links.update', $quickLink->id) : route('admin.quick-links.store') }}" method="POST">
        @csrf
        @if(isset($quickLink))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="title" class="block font-bold mb-2">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title', $quickLink->title ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="Contoh: Akreditasi">
        </div>
        <div class="mb-4">
            <label for="url" class="block font-bold mb-2">URL Tujuan</label>
            <input type="text" name="url" id="url" value="{{ old('url', $quickLink->url ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="/halaman/akreditasi atau https://link.luar">
        </div>
        <div class="mb-4">
            <label for="icon" class="block font-bold mb-2">Ikon (dari Font Awesome)</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $quickLink->icon ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="Contoh: fa-solid fa-star">
            <p class="text-xs text-gray-600 mt-1">Kunjungi <a href="https://fontawesome.com/search" target="_blank" class="text-blue-500">Font Awesome</a>, cari ikon, dan salin kelasnya.</p>
        </div>
        <div class="mb-6">
            <label for="sort_order" class="block font-bold mb-2">Urutan Tampil</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $quickLink->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3">
        </div>
        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($quickLink) ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('admin.quick-links.index') }}" class="ml-4">Batal</a>
        </div>
    </form>
</div>