@php
    // Ambil data logo dari database. Ini cara sederhana, bisa dioptimalkan dengan View Composer jika perlu.
    $logoPath = \App\Models\Setting::where('key', 'site_logo')->value('value');
    $siteName = \App\Models\Setting::where('key', 'site_name')->value('value');
@endphp

<a href="/">
    @if($logoPath)
        <img src="{{ Storage::url($logoPath) }}" alt="{{ $siteName ?? 'Logo' }}" {{ $attributes }}>
    @else
        <h1 class="text-2xl font-bold text-red-600">{{ $siteName ?? 'CMS Universitas' }}</h1>
    @endif
</a>