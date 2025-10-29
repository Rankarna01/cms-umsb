{{-- WIDGET PENGUMUMAN --}}
{{-- Sesuai dengan style 'Berita Terbaru' di contoh Anda, tapi tanpa gambar --}}
@if(isset($latestAnnouncements) && $latestAnnouncements->isNotEmpty())
<div class="rounded-2xl bg-white ring-1 ring-slate-200/70 shadow-md p-6">
    <h3 class="text-lg font-bold mb-4 pb-2 border-b border-slate-200">Pengumuman Terbaru</h3>
    <ul class="space-y-4">
        @foreach ($latestAnnouncements as $item)
            <li>
                <a href="{{ route('announcements.show', $item->slug) }}" class="group">
                    <p class="font-semibold leading-snug line-clamp-2 group-hover:text-red-700">
                        {{ $item->title }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                    </p>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endif

{{-- WIDGET AGENDA --}}
{{-- Sesuai dengan style 'Agenda Terdekat' di contoh Anda --}}
@if(isset($latestEvents) && $latestEvents->isNotEmpty())
<div class="rounded-2xl bg-white ring-1 ring-slate-200/70 shadow-md p-6">
    <h3 class="text-lg font-bold mb-4 pb-2 border-b border-slate-200">Agenda Terdekat</h3>
    <ul class="space-y-4">
        @foreach ($latestEvents as $item)
            <li class="flex items-center gap-4">
                <div class="flex flex-col items-center justify-center rounded-lg bg-red-50 text-red-700 px-3 py-2 ring-1 ring-red-100">
                    <span class="text-xl font-extrabold leading-none">
                        {{ $item->start_date->format('d') }}
                    </span>
                    <span class="text-[10px] uppercase tracking-widest">
                        {{ $item->start_date->format('M') }}
                    </span>
                </div>
                <div class="min-w-0">
                    <a href="{{ route('events.show', $item->slug) }}" class="group">
                        <p class="font-semibold leading-snug line-clamp-2 group-hover:text-red-700">{{ $item->title }}</p>
                        <p class="mt-0.5 text-xs text-slate-500 line-clamp-1">{{ $item->location }}</p>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endif