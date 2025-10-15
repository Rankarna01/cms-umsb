<div x-data="{ url: '{{ old('url', $menuItem->url ?? '') }}' }" class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form action="{{ isset($menuItem) ? route('admin.menu-items.update', $menuItem->id) : route('admin.menu-items.store', $menu->id) }}" method="POST">
        @csrf
        @if(isset($menuItem)) @method('PUT') @endif
        <div class="mb-4"><label for="label" class="block font-bold mb-2">Label</label><input type="text" name="label" id="label" value="{{ old('label', $menuItem->label ?? '') }}" class="shadow border rounded w-full py-2 px-3" required></div>
        <div class="mb-4">
            <label for="page_id" class="block font-bold mb-2">Tautkan ke Halaman Statis</label>
            <select id="page_id" class="shadow border rounded w-full py-2 px-3" x-on:change="url = $event.target.value === '' ? url : $event.target.value">
                <option value="">-- Pilih Halaman untuk ditautkan --</option>
                @foreach($pages as $page)<option value="/halaman/{{ $page->slug }}">{{ $page->title }}</option>@endforeach
            </select>
        </div>
        <div class="mb-4"><label for="url" class="block font-bold mb-2">URL</label><input type="text" name="url" id="url" x-model="url" class="shadow border rounded w-full py-2 px-3 bg-gray-100" required><p class="text-xs text-gray-600 mt-1">Isi manual atau pilih dari daftar di atas.</p></div>
        <div class="mb-4">
            <label for="parent_id" class="block font-bold mb-2">Parent Item</label>
            <select name="parent_id" id="parent_id" class="shadow border rounded w-full py-2 px-3">
                <option value="">-- Tidak Ada (Item Utama) --</option>
                @foreach($parentItems as $item)<option value="{{ $item->id }}" {{ (old('parent_id', $menuItem->parent_id ?? '') == $item->id) ? 'selected' : '' }}>{{ $item->label }}</option>@endforeach
            </select>
        </div>
        @if(isset($menuItem))
        <div class="mb-4">
            <label for="sort_order" class="block font-bold mb-2">Urutan</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $menuItem->sort_order ?? 0) }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        @endif

        {{-- CHECKBOX STATUS BARU --}}
        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $menuItem->active ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Aktifkan item menu ini</span>
            </label>
        </div>
        
        <div class="flex items-center"><button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($menuItem) ? 'Perbarui' : 'Simpan' }}</button><a href="{{ route('admin.menus.show', $menu->id ?? $menuItem->menu_id) }}" class="ml-4">Batal</a></div>
    </form>
</div>
