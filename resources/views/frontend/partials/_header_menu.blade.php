@foreach($items as $item)
    <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
        {{-- Link Utama --}}
        <a href="{{ $item->children->isNotEmpty() ? '#' : url($item->url) }}" 
           class="text-gray-600 hover:text-red-600 flex items-center space-x-1 py-2 {{ $item->children->isNotEmpty() ? 'cursor-default' : '' }}">
            <span>{{ $item->label }}</span>
            @if($item->children->isNotEmpty())
                {{-- Panah ke bawah --}}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                </svg>
            @endif
        </a>

        {{-- Dropdown untuk Sub-menu --}}
        @if($item->children->isNotEmpty())
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="absolute left-0 mt-0 w-56 bg-white rounded-md shadow-lg py-1 z-20">
                @foreach($item->children as $child)
                    <a href="{{ url($child->url) }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                        {{ $child->label }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endforeach
