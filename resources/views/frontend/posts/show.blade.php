@extends('layouts.frontend')

@section('title', $post->title)

@section('content')
    <div class="container mx-auto px-6 py-12">
        <article class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">{{ $post->title }}</h1>
            <div class="text-gray-500 text-sm mt-4">
                <span>Dipublikasikan pada {{ $post->created_at->format('d F Y') }}</span>
                <span class="mx-2">&bull;</span>
                <span>Kategori: <a href="#" class="text-red-600">{{ $post->category->name }}</a></span>
            </div>

            @if($post->thumbnail)
            <figure class="my-8">
                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-lg shadow-lg">
            </figure>
            @endif

            <div class="prose lg:prose-xl max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>
        </article>
    </div>
@endsection