<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form action="{{ isset($leader) ? route('admin.leaders.update', $leader->id) : route('admin.leaders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($leader)) @method('PUT') @endif
        <div class="mb-4"><label for="name" class="block font-bold mb-2">Nama Lengkap</label><input type="text" name="name" id="name" value="{{ old('name', $leader->name ?? '') }}" class="shadow border rounded w-full py-2 px-3" required></div>
        <div class="mb-4"><label for="position" class="block font-bold mb-2">Jabatan</label><input type="text" name="position" id="position" value="{{ old('position', $leader->position ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="Contoh: Rektor"></div>
        <div class="mb-4"><label for="photo" class="block font-bold mb-2">Foto</label>@if(isset($leader) && $leader->photo)<img src="{{ Storage::url($leader->photo) }}" class="h-24 w-auto rounded-lg mb-2">@endif<input type="file" name="photo" id="photo" class="shadow border rounded w-full py-2 px-3"></div>
        <div class="mb-6"><label for="sort_order" class="block font-bold mb-2">Urutan Tampil</label><input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $leader->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3"></div>
        <div class="flex items-center"><button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($leader) ? 'Perbarui' : 'Simpan' }}</button><a href="{{ route('admin.leaders.index') }}" class="ml-4">Batal</a></div>
    </form>
</div>