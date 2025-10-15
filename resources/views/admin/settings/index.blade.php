@extends('layouts.admin')
@section('title', 'Pengaturan Situs')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Pengaturan Situs</h1>
      <p class="text-sm text-slate-500">Atur identitas website, kontak, dan media sosial.</p>
    </div>
  </div>

  {{-- Alert sukses --}}
  @if(session('success'))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
      <i class="fa-regular fa-circle-check mr-2"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    {{-- Identitas Situs --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
      <div class="flex items-center gap-3 mb-4">
        <span class="inline-grid h-10 w-10 place-items-center rounded-xl bg-blue-50 text-blue-600">
          <i class="fa-solid fa-globe"></i>
        </span>
        <div>
          <h2 class="text-lg font-semibold text-slate-800">Identitas Situs</h2>
          <p class="text-sm text-slate-500">Nama, tagline, serta logo & favicon untuk branding.</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-4">
          <div>
            <label for="site_name" class="block text-sm font-medium text-slate-700 mb-1">Nama Website</label>
            <input type="text" name="site_name" id="site_name"
                   value="{{ $settings['site_name'] ?? '' }}"
                   class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                   placeholder="Contoh: CMS Universitas" />
          </div>

          <div>
            <label for="site_tagline" class="block text-sm font-medium text-slate-700 mb-1">Tagline</label>
            <input type="text" name="site_tagline" id="site_tagline"
                   value="{{ $settings['site_tagline'] ?? '' }}"
                   class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                   placeholder="Contoh: Unggul & Berakhlak Mulia" />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="site_logo" class="block text-sm font-medium text-slate-700 mb-2">Logo Website</label>
            @if(isset($settings['site_logo']))
              <div class="mb-3 flex items-center gap-3">
                <img src="{{ Storage::url($settings['site_logo']) }}" class="h-12 w-auto rounded-md ring-1 ring-slate-200" alt="Logo Saat Ini">
                <span class="text-xs text-slate-500">Logo saat ini</span>
              </div>
            @endif
            <input type="file" name="site_logo" id="site_logo"
                   class="block w-full cursor-pointer rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-700 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-white hover:file:bg-blue-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"/>
            <p class="mt-2 text-xs text-slate-500">Disarankan PNG transparan. Maks 1MB.</p>
          </div>

          <div>
            <label for="site_favicon" class="block text-sm font-medium text-slate-700 mb-2">Favicon</label>
            @if(isset($settings['site_favicon']))
              <div class="mb-3 flex items-center gap-3">
                <img src="{{ Storage::url($settings['site_favicon']) }}" class="h-10 w-10 rounded ring-1 ring-slate-200" alt="Favicon Saat Ini">
                <span class="text-xs text-slate-500">Favicon saat ini</span>
              </div>
            @endif
            <input type="file" name="site_favicon" id="site_favicon"
                   class="block w-full cursor-pointer rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-700 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-white hover:file:bg-blue-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"/>
            <p class="mt-2 text-xs text-slate-500">Ukuran persegi (32×32/64×64). PNG/ICO.</p>
          </div>
        </div>
      </div>
    </section>

    {{-- Kontak & Alamat --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
      <div class="flex items-center gap-3 mb-4">
        <span class="inline-grid h-10 w-10 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
          <i class="fa-solid fa-address-card"></i>
        </span>
        <div>
          <h2 class="text-lg font-semibold text-slate-800">Kontak & Alamat</h2>
          <p class="text-sm text-slate-500">Detail alamat, email, dan nomor yang dapat dihubungi.</p>
        </div>
      </div>

      <div class="space-y-4">
        <div>
          <label for="contact_address" class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
          <textarea name="contact_address" id="contact_address" rows="3"
                    class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                    placeholder="Jalan, Kecamatan, Kota, Kode Pos">{{ $settings['contact_address'] ?? '' }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="contact_email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="contact_email" id="contact_email"
                   value="{{ $settings['contact_email'] ?? '' }}"
                   class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                   placeholder="nama@kampus.ac.id" />
          </div>
          <div>
            <label for="contact_phone" class="block text-sm font-medium text-slate-700 mb-1">Telepon</label>
            <input type="text" name="contact_phone" id="contact_phone"
                   value="{{ $settings['contact_phone'] ?? '' }}"
                   class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                   placeholder="+62 8xx xxxx xxxx" />
          </div>

          <div class="mb-4">
                    <label for="map_embed_code" class="block text-gray-700 font-bold mb-2">Kode Embed Google Maps</label>
                    <textarea name="map_embed_code" id="map_embed_code" rows="4" class="shadow border rounded w-full py-2 px-3" placeholder="Paste kode <iframe> dari Google Maps di sini">{{ $settings['map_embed_code'] ?? '' }}</textarea>
                    <p class="text-xs text-gray-600 mt-1">Buka Google Maps, cari lokasi, klik "Share", lalu "Embed a map", dan salin kodenya.</p>
                </div>
        </div>
      </div>
    </section>

    {{-- Media Sosial --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
      <div class="flex items-center gap-3 mb-4">
        <span class="inline-grid h-10 w-10 place-items-center rounded-xl bg-fuchsia-50 text-fuchsia-600">
          <i class="fa-brands fa-hashtag"></i>
        </span>
        <div>
          <h2 class="text-lg font-semibold text-slate-800">Media Sosial</h2>
          <p class="text-sm text-slate-500">Tautan resmi akun kampus untuk ditampilkan di footer/halaman kontak.</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="social_facebook" class="block text-sm font-medium text-slate-700 mb-1">
            <i class="fa-brands fa-facebook text-blue-600 mr-1.5"></i> Facebook URL
          </label>
          <input type="url" name="social_facebook" id="social_facebook"
                 value="{{ $settings['social_facebook'] ?? '' }}"
                 class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                 placeholder="https://facebook.com/..." />
        </div>

        <div>
          <label for="social_instagram" class="block text-sm font-medium text-slate-700 mb-1">
            <i class="fa-brands fa-instagram text-pink-600 mr-1.5"></i> Instagram URL
          </label>
          <input type="url" name="social_instagram" id="social_instagram"
                 value="{{ $settings['social_instagram'] ?? '' }}"
                 class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                 placeholder="https://instagram.com/..." />
        </div>

        <div>
          <label for="social_youtube" class="block text-sm font-medium text-slate-700 mb-1">
            <i class="fa-brands fa-youtube text-red-600 mr-1.5"></i> YouTube URL
          </label>
          <input type="url" name="social_youtube" id="social_youtube"
                 value="{{ $settings['social_youtube'] ?? '' }}"
                 class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                 placeholder="https://youtube.com/..." />
        </div>

        <div>
          <label for="social_twitter" class="block text-sm font-medium text-slate-700 mb-1">
            <i class="fa-brands fa-x-twitter text-slate-800 mr-1.5"></i> Twitter/X URL
          </label>
          <input type="url" name="social_twitter" id="social_twitter"
                 value="{{ $settings['social_twitter'] ?? '' }}"
                 class="w-full rounded-xl border border-slate-200 bg-white/80 px-3.5 py-2.5 text-slate-800 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                 placeholder="https://x.com/..." />
        </div>
      </div>

      {{-- BAGIAN BARU: FITUR TAMBAHAN --}}
            <div class="mb-8">
                <h2 class="text-xl font-semibold border-b pb-2 mb-4">Fitur Tambahan</h2>
                <div class="mb-4">
                    <label for="whatsapp_link" class="block text-gray-700 font-bold mb-2">Link Popup WhatsApp</label>
                    <input type="url" name="whatsapp_link" id="whatsapp_link" value="{{ $settings['whatsapp_link'] ?? '' }}" class="shadow border rounded w-full py-2 px-3" placeholder="https://heylink.me/URLAnda">
                    <p class="text-xs text-gray-600 mt-1">Link ini akan ditampilkan sebagai tombol WhatsApp melayang di pojok kanan bawah website.</p>
                </div>
            </div>

    </section>

    

    {{-- Actions --}}
    <div class="flex items-center gap-3">
      <button type="submit"
              class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
      </button>
      <a href="{{ url()->previous() }}"
         class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
        <i class="fa-solid fa-rotate-left"></i> Batal
      </a>
    </div>
  </form>
</div>
@endsection
