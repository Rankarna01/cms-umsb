{{-- Ganti seluruh isi file _form.blade.php dengan ini --}}
<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())<div class="...">{...}</div>@endif
    <form action="{{ isset($leader) ? route('admin.leaders.update', $leader->id) : route('admin.leaders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($leader)) @method('PUT') @endif
        <div class="mb-4"><label for="name" class="block font-bold mb-2">Nama Lengkap</label><input type="text" name="name" id="name" value="{{ old('name', $leader->name ?? '') }}" class="shadow border rounded w-full py-2 px-3" required></div>
        <div class="mb-4"><label for="position" class="block font-bold mb-2">Jabatan</label><input type="text" name="position" id="position" value="{{ old('position', $leader->position ?? '') }}" class="shadow border rounded w-full py-2 px-3" required></div>
        <div class="mb-4"><label for="photo" class="block font-bold mb-2">Foto</label>@if(isset($leader) && $leader->photo)<img src="{{ Storage::url($leader->photo) }}" class="h-24 w-auto rounded-lg mb-2">@endif<input type="file" name="photo" id="photo" class="shadow border rounded w-full py-2 px-3"></div>
        
        {{-- BAGIAN BARU: MEDIA SOSIAL --}}
        <div class="border-t pt-6 mt-6">
            <h3 class="font-bold mb-4 text-gray-700">Media Sosial (Opsional)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4"><label for="social_facebook" class="block font-bold mb-2 text-sm">Facebook URL</label><input type="url" name="social_facebook" id="social_facebook" value="{{ old('social_facebook', $leader->social_facebook ?? '') }}" class="shadow border rounded w-full py-2 px-3"></div>
                <div class="mb-4"><label for="social_instagram" class="block font-bold mb-2 text-sm">Instagram URL</label><input type="url" name="social_instagram" id="social_instagram" value="{{ old('social_instagram', $leader->social_instagram ?? '') }}" class="shadow border rounded w-full py-2 px-3"></div>
                <div class="mb-4"><label for="social_linkedin" class="block font-bold mb-2 text-sm">LinkedIn URL</label><input type="url" name="social_linkedin" id="social_linkedin" value="{{ old('social_linkedin', $leader->social_linkedin ?? '') }}" class="shadow border rounded w-full py-2 px-3"></div>
                <div class="mb-4"><label for="social_x" class="block font-bold mb-2 text-sm">X / Twitter URL</label><input type="url" name="social_x" id="social_x" value="{{ old('social_x', $leader->social_x ?? '') }}" class="shadow border rounded w-full py-2 px-3"></div>
            </div>
        </div>
        
        <div class="mb-6"><label for="sort_order" class="block font-bold mb-2">Urutan Tampil</label><input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $leader->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3"></div>
        <div class="flex items-center"><button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($leader) ? 'Perbarui' : 'Simpan' }}</button><a href="{{ route('admin.leaders.index') }}" class="ml-4">Batal</a></div>
    </form>
</div>