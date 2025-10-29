<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteSettings['site_name'] ?? 'CMS Universitas' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
     {{-- INI ADALAH WADAH UNTUK MENERIMA STYLE DARI HALAMAN LAIN --}}
    @stack('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            
        }

        .content-fade-in {
            animation: fadeIn 0.75s ease-in-out;
        }
        /* Justify paragraf & list dalam area konten */
  .content-body p,
  .content-body li {
    text-align: justify;
    text-justify: inter-word; /* distribusi spasi lebih rapi */
  }

  /* Bantu pemenggalan kata panjang agar tidak “tumpah” */
  .content-body {
    hyphens: auto;          /* aktifkan pemenggalan (butuh bahasa di HTML/lang) */
    overflow-wrap: anywhere;/* pecah kata sangat panjang jika perlu */
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

{{-- sembunyikan ikon x-cloak saat load --}}
<style>[x-cloak]{display:none !important}</style>

<header x-data="{ open:false }" class="sticky top-0 z-50 bg-white/80 backdrop-blur supports-backdrop-blur:border-b border-slate-200 shadow-sm">
  <nav class="container mx-auto px-4 py-1.5 md:py-2 flex items-center justify-between gap-2 flex-nowrap min-h-[48px]">
    {{-- Brand --}}
    <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
      @if (!empty($siteSettings['site_logo']))
        <img src="{{ Storage::url($siteSettings['site_logo']) }}"
             alt="{{ $siteSettings['site_name'] ?? 'Logo' }}"
             class="h-8 md:h-9 w-auto" />
      @else
        <span class="text-lg md:text-xl font-extrabold tracking-tight text-red-800">
          {{ $siteSettings['site_name'] ?? 'Universitas' }}
        </span>
      @endif
    </a>

    {{-- Desktop Menu (nowrap supaya tidak jadi 2 baris saat zoom) --}}
    <div class="hidden md:flex items-center gap-0.5 font-semibold nav-links whitespace-nowrap">
      @if ($headerMenu && $headerMenu->items->isNotEmpty())
        @include('frontend.partials._header_menu', ['items' => $headerMenu->items])
      @endif
    </div>

    {{-- Mobile Toggle (selalu 1 baris; tombol tidak ikut wrap) --}}
    <button @click="open = !open"
            class="md:hidden inline-flex items-center justify-center shrink-0 rounded-lg p-2 ring-1 ring-slate-300 hover:ring-red-300 hover:bg-red-50 transition"
            aria-label="Toggle menu" :aria-expanded="open.toString()">
      <svg x-show="!open" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m0 6H10"/>
      </svg>
      <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-800" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M6.225 4.811 4.811 6.225 10.586 12l-5.775 5.775 1.414 1.414L12 13.414l5.775 5.775 1.414-1.414L13.414 12l5.775-5.775-1.414-1.414L12 10.586 6.225 4.811z"/>
      </svg>
    </button>
  </nav>

  {{-- Modal Mobile Menu (teleport ke body supaya full-screen & seperti modal) --}}
  <template x-teleport="body">
    <div
      x-show="open"
      x-cloak
      x-transition.opacity.duration.200ms
      x-trap.noscroll.inert="open"  {{-- jika Alpine x-trap tersedia, ini kunci fokus + scroll --}}
      @keydown.escape.window="open=false"
      class="fixed inset-0 z-[60] md:hidden">

      {{-- Backdrop --}}
      <div @click="open=false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

      {{-- Panel (modal sheet) --}}
      <div
        class="absolute inset-x-0 top-0 mt-0 rounded-b-2xl border border-slate-200/70 bg-white shadow-xl"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        @click.outside="open=false"
      >
        <div class="container mx-auto px-4 py-3">
          <div class="flex items-center justify-between">
            <span class="text-sm font-semibold text-slate-500">Menu</span>
            <button @click="open=false" class="p-2 rounded-lg ring-1 ring-slate-300 hover:bg-slate-50" aria-label="Close menu">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700" viewBox="0 0 24 24" fill="currentColor"><path d="M6.225 4.811 4.811 6.225 10.586 12l-5.775 5.775 1.414 1.414L12 13.414l5.775 5.775 1.414-1.414L13.414 12l5.775-5.775-1.414-1.414L12 10.586 6.225 4.811z"/></svg>
            </button>
          </div>

          @if ($headerMenu && $headerMenu->items->isNotEmpty())
            <div class="mt-2 mobile-panel">
              @include('frontend.partials._header_menu', ['items' => $headerMenu->items])
            </div>
          @endif
        </div>
      </div>
    </div>
  </template>
</header>

{{-- Styling link (dipertahankan; tambah util untuk nowrap & no-scrollbar opsional) --}}
<style>
  /* --- Desktop links --- */
  .nav-links{ white-space:nowrap; } /* cegah 2 baris saat zoom */
  .nav-links a{
    font-weight:700; padding:.5rem .75rem; border-radius:.75rem;
    color:#334155; position:relative; transition:color .2s, background-color .2s;
  }
  .nav-links a:hover{ color:#b91c1c; background:#fff1f2; }
  .nav-links a::after{
    content:""; position:absolute; left:12px; right:12px; bottom:6px; height:2px; border-radius:2px;
    background:#ef4444; transform:scaleX(0); transform-origin:left; transition:transform .25s ease; opacity:.9;
  }
  .nav-links a:hover::after{ transform:scaleX(1); }

  /* --- Mobile panel --- */
  .mobile-panel a{
    display:block; font-weight:700; padding:.75rem 0; color:#334155;
    border-bottom:1px solid #e5e7eb; transition:color .2s, background-color .2s;
  }
  .mobile-panel a:last-child{ border-bottom:0; }
  .mobile-panel a:hover{ color:#b91c1c; background:#fff1f2; }

  /* optional: sembunyikan scrollbar jika menu panjang */
  .no-scrollbar::-webkit-scrollbar{ display:none; }
  .no-scrollbar{ -ms-overflow-style:none; scrollbar-width:none; }
</style>




    <main class="content-fade-in">
        
        @yield('content')
    </main>

    <section class="relative overflow-hidden bg-white py-16">
  <div class="container mx-auto px-6">
    {{-- Heading --}}
    <div class="text-center mb-12">
      <span class="inline-block text-red-800 font-extrabold tracking-widest uppercase text-sm border-b-2 border-red-500 pb-1">
        Kontak
      </span>
      <p class="mt-2 text-slate-500 text-sm">Hubungi kami melalui alamat, email, atau telepon.</p>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      {{-- Alamat --}}
      <div class="group rounded-2xl bg-white/70 backdrop-blur ring-1 ring-slate-200 p-6 text-center hover:-translate-y-1 hover:shadow-xl hover:ring-red-400 transition">
        <div class="mx-auto mb-4 w-16 h-16 rounded-2xl grid place-items-center
                    bg-gradient-to-br from-red-600 to-rose-600 text-white shadow-lg ring-1 ring-white/30
                    group-hover:scale-105 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
          </svg>
        </div>
        <h3 class="font-bold text-lg text-slate-900">Alamat</h3>
        <p class="mt-1 text-slate-600">{{ $siteSettings['contact_address'] ?? '-' }}</p>
      </div>

      {{-- Email --}}
      <div class="group rounded-2xl bg-white/70 backdrop-blur ring-1 ring-slate-200 p-6 text-center hover:-translate-y-1 hover:shadow-xl hover:ring-red-400 transition">
        <div class="mx-auto mb-4 w-16 h-16 rounded-2xl grid place-items-center
                    bg-gradient-to-br from-red-600 to-rose-600 text-white shadow-lg ring-1 ring-white/30
                    group-hover:scale-105 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 4H4a2 2 0 0 0-2 2v1.2l10 5.8 10-5.8V6a2 2 0 0 0-2-2Zm0 6.3-8.6 5a1 1 0 0 1-1 0L2 10.3V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.7Z"/>
          </svg>
        </div>
        <h3 class="font-bold text-lg text-slate-900">Email</h3>
        @php $email = $siteSettings['contact_email'] ?? null; @endphp
        <p class="mt-1">
          @if($email)
            <a href="mailto:{{ $email }}" class="text-red-600 hover:underline">{{ $email }}</a>
          @else
            <span class="text-slate-600">-</span>
          @endif
        </p>
      </div>

      {{-- Telp --}}
      <div class="group rounded-2xl bg-white/70 backdrop-blur ring-1 ring-slate-200 p-6 text-center hover:-translate-y-1 hover:shadow-xl hover:ring-red-400 transition">
        <div class="mx-auto mb-4 w-16 h-16 rounded-2xl grid place-items-center
                    bg-gradient-to-br from-red-600 to-rose-600 text-white shadow-lg ring-1 ring-white/30
                    group-hover:scale-105 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6.6 10.8a13.6 13.6 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25c1.1.37 2.3.57 3.6.57a1 1 0 0 1 1 1V20a2 2 0 0 1-2 2C10.2 22 2 13.8 2 4a2 2 0 0 1 2-2h3.5a1 1 0 0 1 1 1c0 1.25.2 2.46.57 3.6a1 1 0 0 1-.25 1L6.6 10.8Z"/>
          </svg>
        </div>
        <h3 class="font-bold text-lg text-slate-900">Telp</h3>
        @php $tel = $siteSettings['contact_phone'] ?? null; @endphp
        <p class="mt-1">
          @if($tel)
            <a href="tel:{{ preg_replace('/\s+/', '', $tel) }}" class="text-red-600 hover:underline">{{ $tel }}</a>
          @else
            <span class="text-slate-600">-</span>
          @endif
        </p>
      </div>
    </div>

    {{-- Map --}}
    <section class="relative py-16 bg-gradient-to-b from-white to-red-50">
  <div class="container mx-auto px-6">
    <div class="text-center mb-10">
      <span class="inline-block text-red-800 font-extrabold tracking-widest uppercase text-sm border-b-2 border-red-800 pb-1">
        Lokasi Kami
      </span>
      <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-gray-800">Temukan Kami di Peta</h2>
      <p class="mt-2 text-gray-500 max-w-2xl mx-auto">
        Kunjungi lokasi kampus kami dengan mudah melalui peta interaktif di bawah ini.
      </p>
    </div>

    <div class="relative overflow-hidden rounded-3xl shadow-2xl ring-1 ring-red-100 hover:ring-red-300 hover:shadow-red-200/70 transition-all duration-500">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.3735659197196!2d100.3329029!3d-0.8555103000000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4c0decbfb4913%3A0x3c3ffc8af780acdd!2sUniversitas%20Muhammadiyah%20Sumatera%20Barat!5e0!3m2!1sid!2sid!4v1759731559922!5m2!1sid!2sid"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        class="w-full h-[400px] md:h-[480px] lg:h-[560px] rounded-3xl border-0">
      </iframe>

      <!-- Efek dekoratif -->
      <div class="absolute -bottom-8 -right-8 h-32 w-32 bg-red-500/10 blur-3xl rounded-full"></div>
    </div>
  </div>
</section>

  </div>
</section>


    <!-- FOOTER -->
<footer class="bg-gradient-to-br from-red-800 to-red-700 text-white">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

            {{-- Kolom 1: Tentang Universitas --}}
            <div>
                <h3 class="font-bold text-lg text-white">
                    {{ $siteSettings['site_name'] ?? 'Universitas' }}
                </h3>
                <p class="mt-3 text-sm text-red-50/90">
                    {{ $siteSettings['contact_address'] ?? 'Alamat belum diatur.' }}
                </p>
                <p class="mt-5 text-sm text-red-50/90">
                    <strong class="text-white">Phone:</strong> {{ $siteSettings['contact_phone'] ?? '-' }}<br>
                    <strong class="text-white">Email:</strong> {{ $siteSettings['contact_email'] ?? '-' }}
                </p>
            </div>

            {{-- Kolom 2: Link Terkait --}}
            <div>
                <h3 class="font-bold text-lg text-white">Link Terkait</h3>
                <ul class="mt-4 space-y-2">
                    @if(isset($footerMenu) && $footerMenu->items->isNotEmpty())
                        @foreach($footerMenu->items as $item)
                            <li>
                                <a href="{{ url($item->url) }}" target="_blank"
                                   class="group text-sm text-red-50/90 hover:text-white hover:underline inline-flex items-center gap-2">
                                    <i class="fa-solid fa-square text-[7px] opacity-80 group-hover:text-white"></i>
                                    <span class="truncate">{{ $item->label }}</span>
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <a href="#" class="text-sm text-red-50/90 hover:text-white hover:underline">Atur link di admin</a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Kolom 3: Media Sosial --}}
            <div>
                <h3 class="font-bold text-lg text-white">Media Sosial</h3>

                <div class="mt-4 flex flex-wrap gap-3">
                    @if(!empty($siteSettings['social_facebook']))
                        <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" aria-label="Facebook"
                           class="inline-flex items-center justify-center h-11 w-11 rounded-full
                                  bg-white/10 text-white ring-1 ring-white/20
                                  hover:bg-white hover:text-red-700
                                  focus:outline-none focus:ring-2 focus:ring-white/60
                                  transition transform hover:scale-[1.03] active:scale-95">
                            <i class="fa-brands fa-facebook-f text-xl"></i>
                        </a>
                    @endif

                    @if(!empty($siteSettings['social_instagram']))
                        <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" aria-label="Instagram"
                           class="inline-flex items-center justify-center h-11 w-11 rounded-full
                                  bg-white/10 text-white ring-1 ring-white/20
                                  hover:bg-white hover:text-red-700
                                  focus:outline-none focus:ring-2 focus:ring-white/60
                                  transition transform hover:scale-[1.03] active:scale-95">
                            <i class="fa-brands fa-instagram text-xl"></i>
                        </a>
                    @endif

                    @if(!empty($siteSettings['social_youtube']))
                        <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" aria-label="YouTube"
                           class="inline-flex items-center justify-center h-11 w-11 rounded-full
                                  bg-white/10 text-white ring-1 ring-white/20
                                  hover:bg-white hover:text-red-700
                                  focus:outline-none focus:ring-2 focus:ring-white/60
                                  transition transform hover:scale-[1.03] active:scale-95">
                            <i class="fa-brands fa-youtube text-xl"></i>
                        </a>
                    @endif

                    @if(!empty($siteSettings['social_x']))
                        <a href="{{ $siteSettings['social_x'] }}" target="_blank" aria-label="X/Twitter"
                           class="inline-flex items-center justify-center h-11 w-11 rounded-full
                                  bg-white/10 text-white ring-1 ring-white/20
                                  hover:bg-white hover:text-red-700
                                  focus:outline-none focus:ring-2 focus:ring-white/60
                                  transition transform hover:scale-[1.03] active:scale-95">
                            <i class="fa-brands fa-x-twitter text-xl"></i>
                        </a>
                    @endif
                </div>

                {{-- optional: teks ajakan --}}
                <p class="mt-4 text-xs text-red-50/80">
                    Ikuti kanal resmi kami untuk pembaruan terbaru.
                </p>
            </div>

        </div>

        <div class="mt-10 border-t border-white/20 pt-6 text-center text-sm text-red-50/90">
            <p>&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Universitas' }}. All Rights Reserved.</p>
        </div>
    </div>
</footer>


 <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl">
            <button id="closeVideoModal" class="absolute -top-10 right-0 text-white text-4xl">&times;</button>
            <div class="aspect-w-16 aspect-h-9">
                <iframe id="videoPlayer" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
{{-- TOMBOL WHATSAPP MELAYANG --}}
@if(!empty($siteSettings['whatsapp_link']))
<a href="{{ $siteSettings['whatsapp_link'] }}" target="_blank"
   class="fixed bottom-6 right-6 z-40 grid h-16 w-16 place-items-center rounded-full bg-green-500 text-white shadow-lg transition-transform hover:scale-110"
   aria-label="Hubungi kami via WhatsApp">
    <i class="fa-brands fa-whatsapp text-4xl"></i>
</a>
@endif

</body>

</html>
