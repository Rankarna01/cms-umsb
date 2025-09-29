@extends('layouts.frontend')

@section('title', $page->title)

@section('content')
    {{-- Tampilkan gambar header jika ada --}}
    @if($page->header_image)
    <div class="w-full h-[40vh] bg-cover bg-center" style="background-image: url('{{ Storage::url($page->header_image) }}');">
        <div class="w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white text-center">{{ $page->title }}</h1>
        </div>
    </div>
    @endif

    <div class="container mx-auto px-6 py-12">
        <article class="max-w-4xl mx-auto">
            
            {{-- Jika tidak ada gambar header, tampilkan judul di sini --}}
            @if(!$page->header_image)
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">{{ $page->title }}</h1>
            @endif

            <div class="prose lg:prose-xl max-w-none">
                {!! nl2br(e($page->content)) !!}
            </div>
            
            @if($page->published_date)
            <div class="text-right text-gray-500 text-sm mt-8 border-t pt-4">
                <span>Dipublikasikan pada {{ \Carbon\Carbon::parse($page->published_date)->format('d F Y') }}</span>
            </div>
            @endif
        </article>
    </div>
@endsection