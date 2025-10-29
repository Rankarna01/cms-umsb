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

    {{-- Sesuaikan action dan method untuk Announcement --}}
    <form action="{{ isset($announcement) ? route('admin.announcements.update', $announcement->id) : route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($announcement))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Kolom Konten Utama --}}
            <div class="md:col-span-2">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $announcement->title ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                </div>

                <div class="mb-4">
                    <label for="slug" class="block text-gray-700 text-sm font-bold mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $announcement->slug ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <p class="text-gray-600 text-xs italic mt-1">Kosongkan agar dibuat otomatis dari judul.</p>
                </div>

                {{-- Textarea Konten dengan ID 'content-editor' --}}
                <div class="mb-4">
                    <label for="content-editor" class="block font-bold mb-2">Konten</label>
                    <textarea name="content" id="content-editor" rows="15" class="shadow border rounded w-full py-2 px-3">{{ old('content', $announcement->content ?? '') }}</textarea>
                </div>
            </div>

            {{-- Kolom Sidebar --}}
            <div class="md:col-span-1">
                

                {{-- Status Aktif (Checkbox) --}}
                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <label class="inline-flex items-center">
                        <input type="hidden" name="active" value="0">
                        <input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $announcement->active ?? true) ? 'checked' : '' }}>
                        <span class="ml-2">Aktifkan pengumuman</span>
                    </label>
                </div>

                {{-- Thumbnail --}}
                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail (Opsional)</label>
                    @if(isset($announcement) && $announcement->thumbnail)
                        <img src="{{ Storage::url($announcement->thumbnail) }}" alt="Current Thumbnail" class="w-full h-auto object-cover rounded mb-2">
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>

                {{-- Dokumen (dari Controller) --}}
                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="document_id" class="block text-gray-700 text-sm font-bold mb-2">Lampiran Dokumen (Opsional)</label>
                    <select name="document_id" id="document_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">-- Tidak ada lampiran --</option>
                        @foreach($documents as $document)
                            <option value="{{ $document->id }}" {{ old('document_id', $announcement->document_id ?? '') == $document->id ? 'selected' : '' }}>
                                {{ $document->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        {{ isset($announcement) ? 'Perbarui' : 'Simpan' }}
                    </button>
                    <a href="{{ route('admin.announcements.index') }}" class="mt-2 inline-block w-full text-center font-bold text-sm text-gray-600 hover:text-gray-800">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ========================================================== --}}
{{-- ## SCRIPT EDITOR (Sama seperti form Berita) ## --}}
{{-- ========================================================== --}}
<script>
    tinymce.init({
        selector: 'textarea#content-editor', // Target ID yang kita set di atas
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
        
        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('admin.images.upload') }}');
            
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
            formData.append('upload', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }),

        height: 500,
        content_style: 'body { font-family:Poppins,sans-serif; font-size:16px }'
    });
</script>