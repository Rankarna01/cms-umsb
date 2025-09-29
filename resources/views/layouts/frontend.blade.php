<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteSettings['site_name'] ?? 'CMS Universitas' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            
        }

        .content-fade-in {
            animation: fadeIn 0.75s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav x-data="{ open: false }" class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                @if (!empty($siteSettings['site_logo']))
                    {{-- Jika logo ada, tampilkan gambar logo --}}
                    <img src="{{ Storage::url($siteSettings['site_logo']) }}"
                        alt="{{ $siteSettings['site_name'] ?? 'Logo' }}" class="h-10 md:h-12 w-auto">
                @else
                    {{-- Jika tidak ada logo, tampilkan teks nama sebagai cadangan --}}
                    <span
                        class="text-xl font-bold text-red-600">{{ $siteSettings['site_name'] ?? 'Universitas' }}</span>
                @endif
            </a>

            <div class="hidden md:flex space-x-6 items-center">
                @if ($headerMenu && $headerMenu->items->isNotEmpty())
                    @include('frontend.partials._header_menu', ['items' => $headerMenu->items])
                @endif
            </div>

            <button @click="open = !open" class="md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </nav>

        <div x-show="open" class="md:hidden">
            @if ($headerMenu && $headerMenu->items->isNotEmpty())
                <div class="px-6 py-2">
                    @include('frontend.partials._header_menu', ['items' => $headerMenu->items])
                </div>
            @endif
        </div>
    </header>

    <main class="content-fade-in">
        
        @yield('content')
    </main>

    <section class="container mx-auto px-6 py-12">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-2 bg-red-100 text-red-600 font-semibold rounded-full text-sm">KONTAK</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="mx-auto mb-4 w-16 h-16 flex items-center justify-center border-2 border-dashed border-red-300 text-red-600 rounded-full text-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <h3 class="font-bold text-lg">Alamat</h3>
                <p class="text-gray-600 mt-1">{{ $siteSettings['contact_address'] ?? '-' }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="mx-auto mb-4 w-16 h-16 flex items-center justify-center border-2 border-dashed border-red-300 text-red-600 rounded-full text-2xl">
                    <svg xmlns="http://www.w.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="font-bold text-lg">Email</h3>
                <p class="text-gray-600 mt-1">{{ $siteSettings['contact_email'] ?? '-' }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="mx-auto mb-4 w-16 h-16 flex items-center justify-center border-2 border-dashed border-red-300 text-red-600 rounded-full text-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                </div>
                <h3 class="font-bold text-lg">Telp</h3>
                <p class="text-gray-600 mt-1">{{ $siteSettings['contact_phone'] ?? '-' }}</p>
            </div>
        </div>
        
        @if(!empty($siteSettings['map_embed_code']))
            <div class="w-full h-96 rounded-lg overflow-hidden shadow-md">
                {!! $siteSettings['map_embed_code'] !!}
            </div>
        @endif
    </section>

    <footer class="bg-red-700 text-white">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-lg">{{ $siteSettings['site_name'] ?? 'Universitas' }}</h3>
                    <p class="mt-2 text-red-100">{{ $siteSettings['site_tagline'] ?? '' }}</p>
                    <p class="mt-4 text-sm text-red-200">{{ $siteSettings['contact_address'] ?? '' }}</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Kontak</h3>
                    <p class="mt-2 text-sm text-red-200">Email: {{ $siteSettings['contact_email'] ?? '-' }}</p>
                    <p class="mt-1 text-sm text-red-200">Telepon: {{ $siteSettings['contact_phone'] ?? '-' }}</p>
                </div>
                <div>
                     <h3 class="font-bold text-lg">Media Sosial</h3>
                     {{-- Logika untuk menampilkan link medsos --}}
                </div>
            </div>
            <div class="mt-8 border-t border-red-600 pt-4 text-center text-sm text-red-200">
                <p>&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Universitas' }}. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>
