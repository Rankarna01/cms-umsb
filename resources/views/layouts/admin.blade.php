<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard') - CMS Universitas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tiny.cloud/1/ys23h8gwq05sytggrgbbeg3l7vu0shazc0igmb58rikzvrgu/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />

    <style>
        .nav-hover::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 0.75rem;
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            transition: box-shadow .25s ease, transform .25s ease;
        }

        .nav-hover:hover::before {
            box-shadow: 0 10px 26px -10px rgba(59, 130, 246, .6);
            transform: translateY(-1px);
        }

        .nice-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .nice-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .15);
            border-radius: 9999px;
        }

        @media (min-width:768px) {
            .w-collapsed {
                width: 5rem !important;
            }

            .ml-collapsed {
                margin-left: 5rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans" x-data="{
    sidebarOpen: false,
    collapsed: false,
    init() { this.collapsed = localStorage.getItem('cms.sidebar.collapsed') === '1' },
    toggleCollapse() {
        this.collapsed = !this.collapsed;
        localStorage.setItem('cms.sidebar.collapsed', this.collapsed ? '1' : '0');
    }
}">

    <div class="flex h-screen">
        <aside id="sidebar"
            class="fixed z-40 inset-y-0 left-0 transform transition-all duration-300 ease-in-out bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700 text-white shadow-2xl border-r border-white/10 pt-16 md:pt-20 nice-scroll overflow-y-auto w-72 md:w-64"
            :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0', collapsed ? 'md:w-collapsed' :
                'md:w-64'
            ]">
            <div class="px-4 md:px-5 pb-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3" title="CMS UMSB">
                    <div class="p-2 rounded-xl bg-white/10 backdrop-blur">
                        <i class="fa-solid fa-building-columns text-white text-xl"></i>
                    </div>
                    <div class="font-extrabold tracking-wide text-lg" x-show="!collapsed">CMS UMSB</div>
                </a>
            </div>
            <nav class="px-2 md:px-3 pb-6">
                <ul class="space-y-1">
                    @php
                        function navLink($route, $icon, $label, $activePatterns = [])
                        {
                            $isActive = false;
                            foreach ($activePatterns as $pat) {
                                if (request()->routeIs($pat)) {
                                    $isActive = true;
                                    break;
                                }
                            }
                            $base =
                                'relative nav-hover group flex items-center gap-3 rounded-xl px-3 py-2.5 transition';
                            $state = $isActive
                                ? 'bg-white/15 text-white font-semibold ring-1 ring-white/20'
                                : 'text-white/80 hover:text-white hover:bg-white/10';
                            return '<li><a href="' .
                                route($route) .
                                '" class="' .
                                $base .
                                ' ' .
                                $state .
                                '" title="' .
                                $label .
                                '">' .
                                '<span class="shrink-0 w-6 text-center"><i class="' .
                                $icon .
                                '"></i></span>' .
                                '<span class="md:inline hidden" x-show="!collapsed">' .
                                $label .
                                '</span>' .
                                '</a></li>';
                        }
                        function navDisabled($icon, $label)
                        {
                            $base =
                                'relative group flex items-center gap-3 rounded-xl px-3 py-2.5 transition pointer-events-none opacity-50 select-none';
                            return '<li><div class="' .
                                $base .
                                '" title="' .
                                $label .
                                ' (tidak aktif)">' .
                                '<span class="shrink-0 w-6 text-center"><i class="' .
                                $icon .
                                '"></i></span>' .
                                '<span class="md:inline hidden" x-show="!collapsed">' .
                                $label .
                                '</span>' .
                                '</div></li>';
                        }
                    @endphp

                    {{-- ======================================== --}}
                    {{-- URUTAN SESUAI RANCANGAN (1 → 15)        --}}
                    {{-- ======================================== --}}

                    {{-- 0. MENU UTAMA --}}
                    <li class="px-3 pt-3 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Menu
                        Utama</li>
                    {!! navLink('dashboard', 'fa-solid fa-house', 'Dashboard', ['dashboard']) !!}

                    {{-- 1. HEADER (Menu & Sub Menu) --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Header
                    </li>
                    @can('kelola menu')
                        {!! navLink('admin.menus.index', 'fa-solid fa-list-check', 'Manajemen Menu', ['admin.menus.*', 'menu-items.*']) !!}
                    @endcan
                    @can('kelola halaman')
                        {!! navLink('admin.pages.index', 'fa-solid fa-file-lines', 'Halaman', ['admin.pages.*']) !!}
                    @endcan

                    {{-- 2. SLIDER --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Slider
                    </li>
                    @can('kelola slider')
                        {!! navLink('admin.sliders.index', 'fa-solid fa-images', 'Slider', ['admin.sliders.*']) !!}
                    @endcan

                    {{-- 3. BERITA (plus Kategori Berita) --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Berita
                    </li>
                    @can('kelola berita')
                        {!! navLink('admin.posts.index', 'fa-solid fa-newspaper', 'Berita', ['admin.posts.*']) !!}
                        {!! navLink('admin.categories.index', 'fa-solid fa-layer-group', 'Kategori Berita', ['admin.categories.*']) !!}
                    @endcan

                    {{-- 4. INFORMASI (Informasi, Pengumuman, Agenda) --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">
                        Informasi</li>
                    {{-- Tidak ada route khusus Informasi → nonaktif --}}
                    {!! navDisabled('fa-solid fa-circle-info', 'Informasi') !!}
                    @can('kelola pengumuman')
                        {!! navLink('admin.announcements.index', 'fa-solid fa-bullhorn', 'Pengumuman', ['admin.announcements.*']) !!}
                    @endcan
                    @can('kelola agenda')
                        {!! navLink('admin.events.index', 'fa-solid fa-calendar-days', 'Agenda', ['admin.events.*']) !!}
                    @endcan
                    @can('kelola pengaturan')
                        {!! navLink('admin.factoids.index', 'fa-solid fa-chart-simple', 'Fakta Kampus', ['admin.factoids.*']) !!}
                    @endcan

                    {{-- 5. DOKUMENTASI (Foto & Video) --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">
                        Dokumentasi</li>
                    @can('kelola galeri')
                        @can('kelola galeri')
                            {!! navLink('admin.albums.index', 'fa-solid fa-layer-group', 'Kategori Galeri', ['admin.albums.*']) !!}
                            {!! navLink('admin.photos.index', 'fa-regular fa-images', 'Galeri Foto', ['admin.photos.*']) !!}
                        @endcan
                        {!! navLink('admin.videos.index', 'fa-regular fa-circle-play', 'Galeri Video', ['admin.videos.*']) !!}
                    @endcan

                    {{-- 6. PIMPINAN / DOSEN --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Pimpinan
                        & Dosen</li>
                    @can('kelola data master')
                        {!! navLink('admin.leaders.index', 'fa-solid fa-user-tie', 'Pimpinan', ['admin.leaders.*']) !!}
                    @endcan
                    {!! navLink('admin.lecturers.index', 'fa-solid fa-chalkboard-user', 'Dosen', ['admin.lecturers.*']) !!}

                    {{-- 7. KERJA SAMA & MEDIA --}}
                    {!! navLink('admin.partners.index', 'fa-solid fa-handshake', 'Kerja Sama & Media', ['admin.partners.*']) !!}

                    {{-- 10. POPUP KONTAK WA --}}
                    {{-- <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Pop-up
                    </li> --}}
                    @can('kelola halaman') {{-- Atau izin lain yang sesuai --}}
    {!! navLink('admin.testimonials.index', 'fa-solid fa-comment-dots', 'Testimoni', ['admin.testimonials.*']) !!}
@endcan
                    @can('kelola pengaturan')
                        {!! navLink('admin.quick-links.index', 'fa-solid fa-bolt', 'Link Cepat', ['admin.quick-links.*']) !!}
                    @endcan
                    @can('kelola halaman') {{-- Ganti dengan izin yang sesuai jika perlu --}}
    {!! navLink('admin.academic-services.index', 'fa-solid fa-graduation-cap', 'Layanan Akademik', ['admin.academic-services.*']) !!}
@endcan

                    {{-- 11. MEMBUAT USER (User & Hak Akses) --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">User &
                        Akses</li>
                    @can('kelola user')
                        {!! navLink('admin.users.index', 'fa-solid fa-users-gear', 'Manajemen User', ['admin.users.*']) !!}
                        {!! navLink('admin.roles.index', 'fa-solid fa-user-shield', 'Manajemen Role', ['admin.roles.*']) !!}
                    @endcan



                    {{-- 13. TESTIMONI ALUMNI --}}
                    {{-- {!! navDisabled('fa-solid fa-quote-left', 'Testimoni Alumni') !!} --}}

                    {{-- 14. KONTEN MENU --}}
                    {{-- {!! navDisabled('fa-solid fa-file-pen', 'Konten Menu') !!} --}}

                    {{-- 15. LAYANAN AKADEMIK --}}
                    {{-- {!! navDisabled('fa-solid fa-book-open-reader', 'Layanan Akademik') !!} --}}

                    {{-- ===================== --}}
                    {{-- LAINNYA (TETAP ADA)  --}}
                    {{-- ===================== --}}
                    <li class="px-3 pt-6 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Lainnya
                    </li>

                    @can('kelola dokumen')
                        {!! navLink('admin.documents.index', 'fa-solid fa-file-shield', 'Dokumen', ['admin.documents.*']) !!}
                    @endcan
                    @can('kelola data master')
                        {!! navLink('admin.faculties.index', 'fa-solid fa-school', 'Fakultas', ['admin.faculties.*']) !!}
                        {!! navLink('admin.study-programs.index', 'fa-solid fa-graduation-cap', 'Program Studi', [
                            'admin.study-programs.*',
                        ]) !!}
                    @endcan

                    {{-- SISTEM --}}
                    <li class="px-3 pt-4 text-[11px] uppercase tracking-wide text-white/50" x-show="!collapsed">Sistem
                    </li>
                    @can('kelola pengaturan')
                        {!! navLink('admin.settings.index', 'fa-solid fa-gear', 'Pengaturan Situs', ['admin.settings.*']) !!}
                    @endcan
                </ul>
            </nav>
            <div class="mt-auto p-3 md:p-4 text-xs text-white/70">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i>
                    <span x-show="!collapsed">Versi 1.0 • © {{ date('Y') }}</span>
                </div>
            </div>
        </aside>

        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-30 md:hidden" x-show="sidebarOpen" x-transition.opacity
            @click="sidebarOpen=false"></div>

        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out pt-16 md:pt-20"
            :class="collapsed ? 'md:ml-collapsed' : 'md:ml-64'">
            <header class="fixed top-0 inset-x-0 z-30 bg-white/80 backdrop-blur border-b border-slate-200">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button
                            class="md:hidden inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50"
                            @click="sidebarOpen=true" aria-label="Open sidebar">
                            <i class="fa-solid fa-bars text-slate-700"></i>
                        </button>
                        <button
                            class="hidden md:inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50"
                            @click="toggleCollapse()" title="Collapse/Expand Sidebar">
                            <i class="fa-solid fa-left-right"></i>
                            <span class="hidden lg:inline">Toggle Sidebar</span>
                        </button>
                    </div>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open=!open" class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-slate-500 text-xs"></i>
                        </button>
                        <div x-show="open" x-transition @click.away="open=false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl border border-slate-100 z-10">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</a>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
