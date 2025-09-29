@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- efek kartu reusable --}}
<style>
  .fx-card{ position:relative; overflow:hidden; }
  .fx-card::before{
    content:""; position:absolute; inset:-40%; background:
      radial-gradient(120px 120px at var(--x,80%) var(--y,0%), rgba(59,130,246,.18), transparent 60%);
    opacity:0; transition:opacity .25s ease;
  }
  .fx-card:hover::before{ opacity:1; }
</style>

<div class="space-y-6">

  {{-- HEADER --}}
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-bold text-slate-800">Dashboard</h1>
  </div>

  {{-- METRIC CARDS (tetap pakai $stats) --}}
  <div class="grid grid-cols-12 gap-6">
    @php
      $cards = [
        ['label'=>'Total Berita','val'=>$stats['posts'],'icon'=>'fa-newspaper','from'=>'from-violet-600','to'=>'to-indigo-600'],
        ['label'=>'Total Halaman','val'=>$stats['pages'],'icon'=>'fa-file-lines','from'=>'from-sky-600','to'=>'to-blue-600'],
        ['label'=>'Total Dosen','val'=>$stats['lecturers'],'icon'=>'fa-chalkboard-user','from'=>'from-emerald-600','to'=>'to-teal-600'],
        ['label'=>'Total Agenda','val'=>$stats['events'],'icon'=>'fa-calendar-days','from'=>'from-amber-600','to'=>'to-orange-500'],
        ['label'=>'Total Fakultas','val'=>$stats['faculties'],'icon'=>'fa-school','from'=>'from-indigo-600','to'=>'to-blue-500'],
        ['label'=>'Total Prodi','val'=>$stats['study_programs'],'icon'=>'fa-graduation-cap','from'=>'from-fuchsia-600','to'=>'to-purple-600'],
        ['label'=>'Total Pengumuman','val'=>$stats['announcements'],'icon'=>'fa-bullhorn','from'=>'from-pink-600','to'=>'to-rose-500'],
        ['label'=>'Total Dokumen','val'=>$stats['documents'],'icon'=>'fa-file-shield','from'=>'from-slate-600','to'=>'to-slate-800'],
      ];
    @endphp

    @foreach ($cards as $c)
      <div class="col-span-12 md:col-span-6 xl:col-span-3">
        <div class="fx-card group rounded-2xl p-5 sm:p-6 bg-gradient-to-br {{ $c['from'] }} {{ $c['to'] }}
                    text-white shadow-lg ring-1 ring-white/10
                    hover:shadow-2xl hover:-translate-y-0.5 transition
                    duration-200 ease-out will-change-transform">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-white/80 text-sm">{{ $c['label'] }}</p>
              <h3 class="text-3xl font-bold text-white mt-1">{{ $c['val'] }}</h3>
            </div>
            <div class="p-2 rounded-xl bg-white/10 text-white">
              <i class="fa-solid {{ $c['icon'] }}"></i>
            </div>
          </div>
          <div class="absolute -right-8 -top-8 opacity-20 text-white">
            <i class="fa-solid {{ $c['icon'] }} text-8xl"></i>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- GRID BAWAH: chart kiri + panel kanan --}}
  <div class="grid grid-cols-12 gap-6">
    {{-- KIRI: Chart utama (pakai $chartData) --}}
    <div class="col-span-12 xl:col-span-8">
      <div class="fx-card bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6"
           onmousemove="this.style.setProperty('--x', event.offsetX+'px'); this.style.setProperty('--y', event.offsetY+'px')">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-slate-800">Grafik Berita (6 Bulan Terakhir)</h2>
          <div class="text-slate-400"><i class="fa-solid fa-chart-column"></i></div>
        </div>
        <div class="h-72 mt-4">
          <canvas id="postsChart"></canvas>
        </div>
      </div>
    </div>

    {{-- KANAN: dua kartu kecil + BERITA TERAKHIR di bawahnya --}}
    <div class="col-span-12 xl:col-span-4 space-y-6">

      {{-- card kecil 1 --}}
      <div class="fx-card rounded-2xl p-5 bg-white shadow-md ring-1 ring-slate-100
                  hover:shadow-xl hover:-translate-y-0.5 transition"
           onmousemove="this.style.setProperty('--x', event.offsetX+'px'); this.style.setProperty('--y', event.offsetY+'px')">
        <div class="flex items-center gap-3">
          <span class="w-11 h-11 rounded-xl grid place-content-center bg-blue-100 text-blue-600">
            <i class="fa-solid fa-hand-holding-dollar"></i>
          </span>
          <div>
            <p class="text-xs text-slate-500">Konten Terbit (Total Berita)</p>
            <p class="text-xl font-bold text-slate-800">{{ $stats['posts'] }}</p>
          </div>
        </div>
      </div>

      {{-- card kecil 2 --}}
      <div class="fx-card rounded-2xl p-5 bg-white shadow-md ring-1 ring-slate-100
                  hover:shadow-xl hover:-translate-y-0.5 transition"
           onmousemove="this.style.setProperty('--x', event.offsetX+'px'); this.style.setProperty('--y', event.offsetY+'px')">
        <div class="flex items-center gap-3">
          <span class="w-11 h-11 rounded-xl grid place-content-center bg-emerald-100 text-emerald-600">
            <i class="fa-solid fa-file-lines"></i>
          </span>
          <div>
            <p class="text-xs text-slate-500">Halaman Aktif</p>
            <p class="text-xl font-bold text-slate-800">{{ $stats['pages'] }}</p>
          </div>
        </div>
      </div>

      {{-- BERITA TERAKHIR --}}
      <div class="fx-card rounded-2xl bg-white shadow-md ring-1 ring-slate-100
                  hover:shadow-lg transition p-5"
           onmousemove="this.style.setProperty('--x', event.offsetX+'px'); this.style.setProperty('--y', event.offsetY+'px')">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-slate-800 font-semibold">Berita Terakhir</h3>
          
        </div>

        @php
          // pastikan controller mengirim $latestPosts (collection)
          // contoh: Post::latest()->take(5)->with('category')->get();
        @endphp

        @if(isset($latestPosts) && $latestPosts->count())
          <ul class="divide-y">
            @foreach($latestPosts as $post)
              <li class="py-3 flex items-start justify-between gap-3 group">
                <div class="flex items-start gap-3">
                  <span class="mt-1 w-9 h-9 rounded-xl grid place-content-center bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-newspaper text-sm"></i>
                  </span>
                  <div>
                    <a href="{{ route('admin.posts.edit', $post) }}"
                       class="font-medium text-slate-800 group-hover:text-indigo-600 transition">
                      {{ Str::limit($post->title, 48) }}
                    </a>
                    <div class="text-[11px] text-slate-500 mt-0.5">
                      {{ optional($post->category)->name ?? 'Tanpa Kategori' }} •
                      {{ $post->created_at->diffForHumans() }}
                      @if(property_exists($post,'views') || isset($post->views))
                        • {{ number_format($post->views) }} views
                      @endif
                    </div>
                  </div>
                </div>
                <a href="{{ route('admin.posts.edit', $post) }}"
                   class="text-slate-400 hover:text-indigo-600 p-2 rounded-lg transition">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
              </li>
            @endforeach
          </ul>
        @else
          <div class="p-4 rounded-xl bg-slate-50 text-slate-500 text-sm">
            Belum ada data berita terbaru.
          </div>
        @endif
      </div>
    </div>
  </div>

</div>

{{-- Chart.js: tetap pakai $chartData milikmu --}}
<script>
  const ctx = document.getElementById('postsChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($chartData['labels']),
      datasets: [{
        label: 'Jumlah Berita',
        data: @json($chartData['data']),
        backgroundColor: 'rgba(59,130,246,0.55)',
        borderColor: 'rgba(59,130,246,1)',
        borderWidth: 1,
        borderRadius: 8,
        maxBarThickness: 36
      }]
    },
    options: {
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{ display:false } },
      scales:{
        x:{ grid:{ display:false } },
        y:{ beginAtZero:true, ticks:{ stepSize:1 }, grid:{ color:'rgba(148,163,184,.15)' } }
      }
    }
  });

  // efek glow mengikuti posisi cursor
  document.querySelectorAll('.fx-card').forEach(el=>{
    el.addEventListener('mousemove', (e)=>{
      const r = el.getBoundingClientRect();
      el.style.setProperty('--x', (e.clientX - r.left)+'px');
      el.style.setProperty('--y', (e.clientY - r.top)+'px');
    });
  });
</script>
@endsection
