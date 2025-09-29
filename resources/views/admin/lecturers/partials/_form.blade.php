<div class="bg-white shadow-md rounded-lg p-8">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($lecturer) ? route('admin.lecturers.update', $lecturer->id) : route('admin.lecturers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($lecturer))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap (dengan gelar)</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $lecturer->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nidn" class="block text-gray-700 text-sm font-bold mb-2">NIDN / NIP</label>
                        <input type="text" name="nidn" id="nidn" value="{{ old('nidn', $lecturer->nidn ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $lecturer->email ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Jabatan</label>
                    <input type="text" name="position" id="position" value="{{ old('position', $lecturer->position ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: Ketua Program Studi">
                </div>
                
                <div class="mb-4">
                    <label for="expertise" class="block text-gray-700 text-sm font-bold mb-2">Bidang Keahlian</label>
                    <textarea name="expertise" id="expertise" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: Rekayasa Perangkat Lunak, Jaringan Komputer">{{ old('expertise', $lecturer->expertise ?? '') }}</textarea>
                </div>
            </div>
            
            <div class="md:col-span-1">
                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Foto Dosen</label>
                    @if(isset($lecturer) && $lecturer->photo)
                        <img src="{{ Storage::url($lecturer->photo) }}" alt="Current photo" class="w-full h-auto object-cover rounded mb-2">
                    @endif
                    <input type="file" name="photo" id="photo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="faculty_id" class="block text-gray-700 text-sm font-bold mb-2">Fakultas</label>
                    <select name="faculty_id" id="faculty_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}" {{ (old('faculty_id', $lecturer->faculty_id ?? '') == $faculty->id) ? 'selected' : '' }}>
                                {{ $faculty->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label for="study_program_id" class="block text-gray-700 text-sm font-bold mb-2">Program Studi</label>
                    <select name="study_program_id" id="study_program_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">-- Pilih Prodi --</option>
                        @foreach($studyPrograms as $program)
                            <option value="{{ $program->id }}" {{ (old('study_program_id', $lecturer->study_program_id ?? '') == $program->id) ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <label class="inline-flex items-center">
                        <input type="hidden" name="active" value="0">
                        <input type="checkbox" name="active" value="1" class="form-checkbox" {{ old('active', $lecturer->active ?? true) ? 'checked' : '' }}>
                        <span class="ml-2">Tampilkan di website</span>
                    </label>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ isset($lecturer) ? 'Perbarui' : 'Simpan' }}</button>
                    <a href="{{ route('admin.lecturers.index') }}" class="mt-2 inline-block w-full text-center font-bold text-sm text-gray-600 hover:text-gray-800">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>