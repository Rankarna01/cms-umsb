@extends('layouts.frontend')
@section('title', $lecturer->name)

@section('content')

{{-- HEADER GRADIENT --}}
<header class="relative overflow-hidden bg-gradient-to-br from-red-800 to-red-800 text-white">
  <div class="absolute inset-0 opacity-10">
    <div class="h-full w-full bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
  </div>
  <div class="container mx-auto px-6 py-12 lg:py-14 relative">
    <nav class="mb-3 text-sm text-red-100/90 flex items-center gap-2">
      <a href="{{ route('home') }}" class="inline-flex items-center gap-2 hover:text-white transition">
        <i class="fa-solid fa-house"></i><span>Home</span>
      </a>
      <i class="fa-solid fa-chevron-right text-xs text-red-200/80"></i>
      <a href="{{ route('lecturers.index') }}" class="hover:text-white/90 transition">Dosen</a>
      <i class="fa-solid fa-chevron-right text-xs text-red-200/80"></i>
      <span class="line-clamp-1">{{ $lecturer->name }}</span>
    </nav>
    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight drop-shadow-sm">{{ $lecturer->name }}</h1>
    @if($lecturer->functional_position || $lecturer->position)
      <p class="mt-2 text-red-100/90 text-lg">{{ $lecturer->functional_position ?? $lecturer->position }}</p>
    @endif
  </div>
</header>

<main class="bg-gradient-to-b from-gray-50 to-white py-10 lg:py-12">
  <div class="container mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

      {{-- KONTEN UTAMA (KIRI) --}}
      <div class="lg:col-span-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
          <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 md:gap-8">
            {{-- Foto Dosen --}}
            <div class="flex-shrink-0">
              <img src="{{ $lecturer->photo ? Storage::url($lecturer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lecturer->name) . '&size=200' }}" alt="{{ $lecturer->name }}" class="w-40 h-40 md:w-48 md:h-48 rounded-full object-cover ring-2 ring-red-50" />
            </div>

            {{-- Informasi Utama --}}
            <div class="text-center sm:text-left">
              <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">{{ $lecturer->name }}</h1>
              <p class="text-sm md:text-base text-red-600 font-semibold mt-1">{{ $lecturer->functional_position ?? $lecturer->position }}</p>
              <div class="mt-2 flex flex-wrap items-center justify-center sm:justify-start gap-2">
                @if($lecturer->studyProgram?->name)
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 text-red-700 px-3 py-1 text-xs font-medium"><i class="fa-solid fa-layer-group"></i>{{ $lecturer->studyProgram->name }}</span>
                @endif
                @if($lecturer->faculty?->name)
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 text-gray-700 px-3 py-1 text-xs font-medium"><i class="fa-solid fa-building-columns"></i>{{ $lecturer->faculty->name }}</span>
                @endif
              </div>

              {{-- Link Eksternal dengan Ikon (compact) --}}
              <div class="mt-4 grid grid-cols-3 place-items-center max-w-[200px] sm:justify-start text-gray-400 mx-auto sm:mx-0">
                @if($lecturer->link_pddikti)
                  <a href="{{ $lecturer->link_pddikti }}" target="_blank" class="hover:text-red-600 transition" title="Profil PDDIKTI" aria-label="PDDIKTI"><i class="fa-solid fa-graduation-cap text-base"></i></a>
                @else
                  <span class="opacity-30"><i class="fa-solid fa-graduation-cap text-base"></i></span>
                @endif
                @if($lecturer->link_sinta)
                  <a href="{{ $lecturer->link_sinta }}" target="_blank" class="hover:text-red-600 transition" title="Profil SINTA" aria-label="SINTA"><i class="fa-solid fa-book-open text-base"></i></a>
                @else
                  <span class="opacity-30"><i class="fa-solid fa-book-open text-base"></i></span>
                @endif
                @if($lecturer->link_scholar)
                  <a href="{{ $lecturer->link_scholar }}" target="_blank" class="hover:text-red-600 transition" title="Profil Google Scholar" aria-label="Google Scholar"><i class="fa-brands fa-google-scholar text-base"></i></a>
                @else
                  <span class="opacity-30"><i class="fa-brands fa-google-scholar text-base"></i></span>
                @endif
              </div>
            </div>
          </div>

          {{-- Informasi Detail --}}
          <div class="border-t mt-8 pt-6">
            <h2 class="text-sm font-semibold text-gray-600 tracking-wide uppercase mb-4">Informasi Detail</h2>
            <div class="space-y-3">
              <div class="grid grid-cols-3 gap-3">
                <span class="col-span-1 text-gray-500">NIDN</span>
                <span class="col-span-2 font-medium text-gray-900">{{ $lecturer->nidn ?? '-' }}</span>
              </div>
              <div class="grid grid-cols-3 gap-3">
                <span class="col-span-1 text-gray-500">NIK</span>
                <span class="col-span-2 font-medium text-gray-900">{{ $lecturer->nik ?? '-' }}</span>
              </div>
              <div class="grid grid-cols-3 gap-3">
                <span class="col-span-1 text-gray-500">NBM</span>
                <span class="col-span-2 font-medium text-gray-900">{{ $lecturer->nbm ?? '-' }}</span>
              </div>
              <div class="grid grid-cols-3 gap-3">
                <span class="col-span-1 text-gray-500">Email</span>
                <span class="col-span-2 font-medium text-gray-900 break-all">{{ $lecturer->email ?? '-' }}</span>
              </div>
              <div class="grid grid-cols-3 gap-3">
                <span class="col-span-1 text-gray-500">Bidang Ilmu</span>
                <span class="col-span-2 font-medium text-gray-900">{{ $lecturer->expertise ?? '-' }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- SIDEBAR KANAN: DOSEN LAINNYA --}}
      <aside class="lg:col-span-4">
        <div class="sticky top-24 space-y-6">
          @if($relatedLecturers->isNotEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
              <h3 class="text-base font-semibold mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                <i class="fa-solid fa-user-group text-red-600"></i>
                <span>Dosen Lain di Fakultas Ini</span>
              </h3>
              <ul class="space-y-3">
                @foreach($relatedLecturers as $related)
                  <li>
                    <a href="{{ route('lecturers.show', $related->nidn) }}" class="group flex items-center gap-3 rounded-xl p-2 hover:bg-gray-50 transition">
                      <img src="{{ $related->photo ? Storage::url($related->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($related->name) . '&size=64' }}" alt="{{ $related->name }}" class="h-12 w-12 rounded-full object-cover flex-shrink-0 ring-1 ring-gray-100" />
                      <div class="min-w-0">
                        <p class="text-[13px] font-semibold leading-snug line-clamp-2 group-hover:text-red-600">{{ $related->name }}</p>
                        <p class="mt-0.5 text-[11px] text-gray-500">{{ $related->functional_position ?? $related->position }}</p>
                      </div>
                      <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-red-500"></i>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
      </aside>

    </div>
  </div>
</main>
@endsection
