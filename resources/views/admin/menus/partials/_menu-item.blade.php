<li class="bg-gray-50 p-3 rounded-lg border">
    <div class="flex justify-between items-center">
        <div>
            <span class="font-semibold">{{ $item->label }}</span>
            <span class="text-xs text-gray-500 ml-2">({{ $item->url }})</span>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
            <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini dan semua sub-itemnya?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
            </form>
        </div>
    </div>
    @if($item->children->isNotEmpty())
        <ul class="space-y-2 mt-3 pl-6 border-l-2">
            @foreach($item->children as $child)
                @include('admin.menus.partials._menu-item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>