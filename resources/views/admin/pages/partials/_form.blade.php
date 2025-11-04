<div class="bg-white shadow-md rounded-lg p-8">
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($page)) @method('PUT') @endif

    <div class="mb-4">
        <label for="title" class="block font-bold mb-2">Judul Halaman</label>
        <input type="text" name="title" id="title" value="{{ old('title', $page->title ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
    </div>
    
    <div class="mb-4">
        <label for="slug" class="block font-bold mb-2">Slug (Opsional)</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug ?? '') }}" class="shadow border rounded w-full py-2 px-3">
        <p class="text-gray-600 text-xs italic mt-1">Kosongkan agar dibuat otomatis dari judul.</p>
    </div>

    <div class="mb-4">
        <label for="summary" class="block font-bold mb-2">Ringkasan (Opsional)</label>
        <textarea name="summary" id="summary" rows="3" class="shadow border rounded w-full py-2 px-3">{{ old('summary', $page->summary ?? '') }}</textarea>
    </div>
    
    <div class="mb-4">
        <label for="content-editor" class="block font-bold mb-2">Konten</label>
        <textarea name="content" id="content-editor" rows="15" class="shadow border rounded w-full py-2 px-3">{{ old('content', $page->content ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
            <label for="header_image" class="block font-bold mb-2">Gambar Header (Opsional)</label>
            
            {{-- BAGIAN BARU DENGAN CHECKBOX HAPUS --}}
            @if(isset($page) && $page->header_image)
            <div class="relative w-1/2">
                <img src="{{ Storage::url($page->header_image) }}" class="rounded mb-2 shadow" alt="Header">
                <div class="mt-2">
                    <label class="inline-flex items-center text-sm">
                        <input type="checkbox" name="delete_header_image" value="1" class="form-checkbox h-4 w-4 text-red-600">
                        <span class="ml-2 text-red-700 font-semibold">Hapus gambar header ini</span>
                    </label>
                </div>
            </div>
            @endif
            
            <input type="file" name="header_image" id="header_image" class="shadow border rounded w-full py-2 px-3 mt-2">
             @if(isset($page) && $page->header_image)
                <p class="text-xs text-gray-600 mt-1">Upload gambar baru untuk mengganti, atau centang hapus.</p>
             @endif
        </div>
        <div>
            <label for="published_date" class="block font-bold mb-2">Tanggal Publikasi (Opsional)</label>
            <input type="date" name="published_date" id="published_date" value="{{ old('published_date', $page->published_date ?? '') }}" class="shadow border rounded w-full py-2 px-3">
        </div>
    </div>

    <div class="mb-6"><label class="inline-flex items-center"><input type="hidden" name="active" value="0"><input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $page->active ?? true) ? 'checked' : '' }}><span class="ml-2">Aktifkan halaman ini</span></label></div>
    <div class="flex items-center"><button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($page) ? 'Perbarui' : 'Simpan' }}</button><a href="{{ route('admin.pages.index') }}" class="ml-4">Batal</a></div>
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

