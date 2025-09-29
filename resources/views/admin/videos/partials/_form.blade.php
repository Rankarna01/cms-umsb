<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ isset($video) ? route('admin.videos.update', $video->id) : route('admin.videos.store') }}" method="POST">
        @csrf
        @if(isset($video)) @method('PUT') @endif
        <div class="mb-4">
            <label for="title" class="block font-bold mb-2">Judul Video</label>
            <input type="text" name="title" id="title" value="{{ old('title', $video->title ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label for="video_url" class="block font-bold mb-2">URL Video (YouTube, Vimeo, dll)</label>
            <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $video->video_url ?? '') }}" class="shadow border rounded w-full py-2 px-3" required placeholder="https://www.youtube.com/watch?v=xxxxxx">
        </div>
        <div class="mb-4">
            <label for="caption" class="block font-bold mb-2">Caption (Opsional)</label>
            <textarea name="caption" id="caption" rows="3" class="shadow border rounded w-full py-2 px-3">{{ old('caption', $video->caption ?? '') }}</textarea>
        </div>
        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($video) ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('admin.videos.index') }}" class="ml-4">Batal</a>
        </div>
    </form>
</div>