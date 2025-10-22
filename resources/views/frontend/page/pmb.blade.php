@extends('layouts.frontend')
@section('title', $page->title)

@section('content')
{{-- HEADER HALAMAN --}}
<header class="bg-red-800 text-white">
<div class="container mx-auto px-6 py-12">
<h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">{{ $page->title }}</h1>
</div>
</header>

<main class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- KONTEN UTAMA (KIRI) --}}
        <article class="lg:col-span-8 bg-white p-6 md:p-10 rounded-lg shadow-xl">
            <div class="prose prose-lg lg:prose-xl max-w-none prose-img:rounded-xl prose-a:text-red-600">
                {!! $page->content !!}
            </div>
        </article>

        {{-- SIDEBAR KANAN: LINK CEPAT --}}
        <aside class="lg:col-span-4">
            <div class="sticky top-24 bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4 border-b pb-2">Akses Cepat PMB</h3>
                <ul class="space-y-3">
                    @foreach($quickLinks as $link)
                        <li>
                            <a href="{{ url($link->url) }}" class="flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-red-50 hover:text-red-700 font-medium transition-colors">
                                <div class="flex-shrink-0 w-8 text-center">
                                    <i class="{{ $link->icon }} text-red-600 text-xl"></i>
                                </div>
                                <span>{{ $link->title }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</main>


@endsection