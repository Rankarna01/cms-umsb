@extends('layouts.frontend')

@section('content')

    @if($sliders->isNotEmpty())
    <section class="w-full h-[60vh] bg-gray-200">
        <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ Storage::url($sliders->first()->image) }}');">
            <div class="w-full h-full bg-black bg-opacity-40 flex items-center justify-center">
                <div class="text-center text-white p-4">
                    <h1 class="text-4xl md:text-6xl font-bold">{{ $sliders->first()->title }}</h1>
                    <p class="mt-4 text-lg">{{ $sliders->first()->caption }}</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($latestPosts->isNotEmpty())
    <section class="container mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Berita Terkini</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                <a href="{{ route('posts.show', $post->slug) }}">
                    <img src="{{ $post->thumbnail ? Storage::url($post->thumbnail) : 'https://via.placeholder.com/400x300' }}" alt="{{ $post->title }}" class="w-full h-56 object-cover">
                </a>
                <div class="p-6">
                    <span class="text-sm text-red-600">{{ $post->category->name }}</span>
                    <h3 class="font-semibold text-lg mt-2 truncate">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-red-600">{{ $post->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm mt-2">{{ Str::limit($post->excerpt, 100) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
    
    @if($factoids->isNotEmpty())
    <section class="container mx-auto px-6 py-12">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-2 bg-red-100 text-red-600 font-semibold rounded-full text-sm">FAKTA UM SUMATERA BARAT</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 text-center">
            @foreach($factoids as $factoid)
            <div>
                <div class="mx-auto mb-4 w-20 h-20 flex items-center justify-center bg-red-600 text-white rounded-full text-4xl">
                    <i class="{{ $factoid->icon ?? 'fa-solid fa-graduation-cap' }}"></i>
                </div>
                <p class="text-4xl font-bold text-gray-800">{{ $factoid->value }}</p>
                <p class="text-gray-600 mt-1">{{ $factoid->label }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($upcomingEvents->isNotEmpty())
    <section class="bg-red-50">
        <div class="container mx-auto px-6 py-12">
            <h2 class="text-3xl font-bold text-center mb-8">Agenda Terdekat</h2>
            <div class="space-y-6 max-w-4xl mx-auto">
                @forelse($upcomingEvents as $event)
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-6">
                    <div class="text-center bg-red-600 text-white rounded-lg p-4">
                        <p class="text-4xl font-bold">{{ $event->start_date->format('d') }}</p>
                        <p class="text-sm uppercase">{{ $event->start_date->format('M') }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm">{{ $event->location }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500">Belum ada agenda terdekat.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    @if($leaders->isNotEmpty())
    <section class="container mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-center mb-10">Pimpinan Universitas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($leaders as $leader)
            <div class="text-center">
                <div class="relative w-48 h-48 mx-auto mb-4">
                    <img src="{{ $leader->photo ? Storage::url($leader->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($leader->name) . '&size=192' }}" alt="{{ $leader->name }}" class="w-full h-full rounded-full object-cover shadow-lg">
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $leader->name }}</h3>
                <p class="text-gray-600">{{ $leader->position }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($partners->isNotEmpty())
    <section class="bg-gray-50">
        <div class="container mx-auto px-6 py-12">
            <div class="text-center mb-10">
                <span class="inline-block px-4 py-2 bg-red-100 text-red-600 font-semibold rounded-full text-sm">KERJA SAMA</span>
            </div>
            <div class="flex flex-wrap justify-center items-center gap-x-12 gap-y-8">
                @foreach ($partners as $partner)
                    <a href="{{ $partner->website_url ?? '#' }}" target="_blank" title="{{ $partner->name }}">
                        <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
                            class="h-16 w-auto grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition duration-300">
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection