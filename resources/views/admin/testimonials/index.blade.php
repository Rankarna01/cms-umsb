@extends('layouts.admin')
@section('title', 'Manajemen Testimoni')

@section('content')
<div class="flex justify-between items-center mb-6">
<h1 class="text-3xl font-bold">Manajemen Testimoni</h1>
<a href="{{ route('admin.testimonials.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
+ Tambah Testimoni
</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border text-green-700 px-4 py-3 rounded mb-4" role="alert">
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Alumni</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Testimoni</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Status</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-center text-xs font-semibold uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($testimonials as $testimonial)
                <tr>
                    <td class="px-5 py-4 border-b w-1/4">
                        <div class="flex items-center">
                            <img class="h-12 w-12 rounded-full object-cover flex-shrink-0" src="{{ $testimonial->photo ? Storage::url($testimonial->photo) : 'https://ui-avatars.com/api/?name='.urlencode($testimonial->name) }}" alt="{{ $testimonial->name }}">
                            <div class="ml-4">
                                <p class="font-semibold">{{ $testimonial->name }}</p>
                                <p class="text-xs text-gray-600">{{ $testimonial->occupation ?? 'Angkatan ' . $testimonial->graduation_year }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 border-b">
                        <p class="text-sm text-gray-700 italic">"{{ Str::limit($testimonial->content, 100) }}"</p>
                    </td>
                    <td class="px-5 py-4 border-b text-center">
                         @if($testimonial->active)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-200 text-green-800">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-200 text-red-800">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 border-b text-center whitespace-nowrap">
                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="text-indigo-600">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-10 text-gray-500">Belum ada data testimoni.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>


@endsection