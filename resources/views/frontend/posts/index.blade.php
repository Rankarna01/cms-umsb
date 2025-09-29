@extends('layouts.frontend')

@section('title', 'Berita')

@section('content')
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold text-center mb-8">Semua Berita</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
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
            @empty
            <p class="col-span-full text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
@endsection