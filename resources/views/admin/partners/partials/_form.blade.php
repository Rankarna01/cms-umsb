<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form action="{{ isset($partner) ? route('admin.partners.update', $partner->id) : route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($partner)) @method('PUT') @endif
        <div class="mb-4"><label for="name" class="block font-bold mb-2">Nama Instansi/Media</label><input type="text" name="name" id="name" value="{{ old('name', $partner->name ?? '') }}" class="shadow border rounded w-full py-2 px-3" required></div>
        <div class="mb-4"><label for="type" class="block font-bold mb-2">Tipe</label><select name="type" id="type" class="shadow border rounded w-full py-2 px-3"><option value="kerjasama" @if(old('type', $partner->type ?? '') == 'kerjasama') selected @endif>Kerja Sama</option><option value="media" @if(old('type', $partner->type ?? '') == 'media') selected @endif>Media</option></select></div>
        <div class="mb-4"><label for="website_url" class="block font-bold mb-2">Website URL (Opsional)</label><input type="url" name="website_url" id="website_url" value="{{ old('website_url', $partner->website_url ?? '') }}" class="shadow border rounded w-full py-2 px-3" placeholder="https://contoh.com"></div>
        <div class="mb-4"><label for="logo" class="block font-bold mb-2">Logo</label>@if(isset($partner) && $partner->logo)<img src="{{ Storage::url($partner->logo) }}" class="h-16 w-auto mb-2">@endif<input type="file" name="logo" id="logo" class="shadow border rounded w-full py-2 px-3"></div>
        <div class="mb-6"><label for="sort_order" class="block font-bold mb-2">Urutan Tampil</label><input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3"></div>
        <div class="flex items-center"><button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($partner) ? 'Perbarui' : 'Simpan' }}</button><a href="{{ route('admin.partners.index') }}" class="ml-4">Batal</a></div>
    </form>
</div>