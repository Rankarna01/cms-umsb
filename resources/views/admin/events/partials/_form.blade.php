<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($event) ? route('admin.events.update', $event->id) : route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($event))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Agenda</label>
            <input type="text" name="title" id="title" value="{{ old('title', $event->title ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Waktu Mulai</label>
                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', isset($event) ? $event->start_date->format('Y-m-d\TH:i') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Waktu Selesai (Opsional)</label>
                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', isset($event) && $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>
        </div>
        
        <div class="mb-4">
            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi</label>
            <input type="text" name="location" id="location" value="{{ old('location', $event->location ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        {{-- ========================================================== --}}
        {{-- ## PERUBAHAN DI SINI: Textarea diubah jadi Rich Editor ## --}}
        {{-- ========================================================== --}}
        <div class="mb-4">
            <label for="content-editor" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" id="content-editor" rows="15" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('description', $event->description ?? '') }}</textarea>
        </div>
        
        <div class="mb-4">
            <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail (Opsional)</label>
            @if(isset($event) && $event->thumbnail)
                <img src="{{ Storage::url($event->thumbnail) }}" alt="Current thumbnail" class="w-1/3 rounded mb-2">
            @endif
            <input type="file" name="thumbnail" id="thumbnail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="contact_person" class="block text-gray-700 text-sm font-bold mb-2">Kontak Person (Opsional)</label>
                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $event->contact_person ?? '') }}" placeholder="Nama - 08123456789" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <label class="inline-flex items-center mt-2">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $event->active ?? true) ? 'checked' : '' }}>
                    <span class="ml-2">Aktifkan agenda ini</span>
                </label>
            </div>
        </div>

        <div class="mb-4">
            <label for="document_id" class="block text-gray-700 text-sm font-bold mb-2">Lampiran Dokumen (Opsional)</label>
            <select name="document_id" id="document_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                <option value="">-- Tidak ada lampiran --</option>
                @foreach($documents as $document)
                    <option value="{{ $document->id }}" {{ old('document_id', $event->document_id ?? '') == $document->id ? 'selected' : '' }}>
                        {{ $document->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ isset($event) ? 'Perbarui Agenda' : 'Simpan Agenda' }}
            </button>
            <a href="{{ route('admin.events.index') }}" class="ml-4 text-gray-600">Batal</a>
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