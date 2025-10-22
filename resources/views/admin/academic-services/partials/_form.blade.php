<div class="bg-white shadow-md rounded-lg p-8">
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ isset($academicService) ? route('admin.academic-services.update', $academicService->id) : route('admin.academic-services.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($academicService))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="title" class="block font-bold mb-2">Judul Layanan</label>
        <input type="text" name="title" id="title" value="{{ old('title', $academicService->title ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="Contoh: SIAK">
    </div>
    <div class="mb-4">
        <label for="description" class="block font-bold mb-2">Deskripsi Singkat</label>
        <textarea name="description" id="description" rows="3" class="shadow border rounded w-full py-2 px-3" placeholder="Contoh: Sistem Informasi Akademik Mahasiswa">{{ old('description', $academicService->description ?? '') }}</textarea>
    </div>
    <div class="mb-4">
        <label for="url" class="block font-bold mb-2">URL Tujuan</label>
        <input type="text" name="url" id="url" value="{{ old('url', $academicService->url ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="https://siak.kampus.ac.id">
    </div>
    <div class="mb-4">
        <label for="image" class="block font-bold mb-2">Gambar Ikon (Opsional)</label>
        @if(isset($academicService) && $academicService->image)
            <img src="{{ Storage::url($academicService->image) }}" class="h-20 w-20 rounded-full object-cover mb-2">
        @endif
        <input type="file" name="image" id="image" class="shadow border rounded w-full py-2 px-3">
    </div>
    <div class="mb-6">
        <label for="sort_order" class="block font-bold mb-2">Urutan Tampil</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $academicService->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3">
    </div>
    <div class="flex items-center">
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($academicService) ? 'Perbarui' : 'Simpan' }}</button>
        <a href="{{ route('admin.academic-services.index') }}" class="ml-4">Batal</a>
    </div>
</form>


</div>