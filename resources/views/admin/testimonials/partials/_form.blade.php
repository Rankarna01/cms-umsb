<div class="bg-white shadow-md rounded-lg p-8">
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($testimonial))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block font-bold mb-2">Nama Alumni</label>
            <input type="text" name="name" id="name" value="{{ old('name', $testimonial->name ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div>
            <label for="photo" class="block font-bold mb-2">Foto (Opsional)</label>
            @if(isset($testimonial) && $testimonial->photo)
                <img src="{{ Storage::url($testimonial->photo) }}" class="h-16 w-16 rounded-full object-cover mb-2">
            @endif
            <input type="file" name="photo" id="photo" class="shadow border rounded w-full py-2 px-3">
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
         <div>
            <label for="graduation_year" class="block font-bold mb-2">Angkatan / Tahun Lulus</label>
            <input type="text" name="graduation_year" id="graduation_year" value="{{ old('graduation_year', $testimonial->graduation_year ?? '') }}" class="shadow border rounded w-full py-2 px-3" placeholder="Contoh: 2020">
        </div>
        <div>
            <label for="occupation" class="block font-bold mb-2">Pekerjaan / Jabatan</label>
            <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $testimonial->occupation ?? '') }}" class="shadow border rounded w-full py-2 px-3" placeholder="Contoh: Software Engineer">
        </div>
    </div>
    <div class="mt-4">
        <label for="content" class="block font-bold mb-2">Isi Testimoni</label>
        <textarea name="content" id="content" rows="5" class="shadow border rounded w-full py-2 px-3" required>{{ old('content', $testimonial->content ?? '') }}</textarea>
    </div>
    <div class="mt-4">
        <label for="sort_order" class="block font-bold mb-2">Urutan Tampil</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3">
    </div>
    <div class="mt-6 mb-6">
        <label class="inline-flex items-center">
            <input type="hidden" name="active" value="0">
            <input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $testimonial->active ?? true) ? 'checked' : '' }}>
            <span class="ml-2">Tampilkan di halaman depan</span>
        </label>
    </div>

    <div class="flex items-center">
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($testimonial) ? 'Perbarui' : 'Simpan' }}</button>
        <a href="{{ route('admin.testimonials.index') }}" class="ml-4">Batal</a>
    </div>
</form>


</div>