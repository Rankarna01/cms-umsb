<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="slug" class="block text-gray-700 text-sm font-bold mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-gray-600 text-xs italic mt-1">Kosongkan agar dibuat otomatis dari judul.</p>
                </div>

                <div class="mb-4">
                    <label for="excerpt" class="block text-gray-700 text-sm font-bold mb-2">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                </div>

               <div class="mb-4">
            <label for="content-editor" class="block font-bold mb-2">Konten</label>
            <textarea name="content" id="content-editor" rows="15" class="shadow border rounded w-full py-2 px-3">{{ old('content', $page->content ?? '') }}</textarea>
        </div>
            </div>

            <div class="md:col-span-1">
                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                    <select name="category_id" id="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $post->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" id="status" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="draft" {{ (old('status', $post->status ?? 'draft') == 'draft') ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ (old('status', $post->status ?? '') == 'published') ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ (old('status', $post->status ?? '') == 'archived') ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Opsi</label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="headline" value="1" class="form-checkbox" {{ old('headline', $post->headline ?? false) ? 'checked' : '' }}>
                        <span class="ml-2">Jadikan Headline</span>
                    </label>
                </div>

                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail</label>
                    @if(isset($post) && $post->thumbnail)
                        <img src="{{ asset('storage/' . Str::after($post->thumbnail, 'public/')) }}" alt="Current Thumbnail" class="w-full h-auto object-cover rounded mb-2">
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        {{ isset($post) ? 'Perbarui Berita' : 'Simpan Berita' }}
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="mt-2 inline-block w-full text-center font-bold text-sm text-gray-600 hover:text-gray-800">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    tinymce.init({
        selector: 'textarea#content-editor',
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
        
        // --- PERBAIKAN UTAMA DI SINI ---
        // Kita gunakan handler manual agar bisa menyisipkan CSRF Token
        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('admin.images.upload') }}');
            
            // Ambil CSRF token dari meta tag
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            // 'upload' adalah nama field yang diharapkan oleh ImageUploadController kita
            formData.append('upload', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        }),

        height: 500,
        content_style: 'body { font-family:Poppins,sans-serif; font-size:16px }'
    });
</script>