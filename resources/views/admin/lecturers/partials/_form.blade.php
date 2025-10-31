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

{{-- INFORMASI DASAR --}}
<div class="mb-4">
    <label for="name" class="block font-bold mb-2">Nama Dosen</label>
    <input type="text" name="name" id="name" value="{{ old('name', $lecturer->name ?? '') }}" class="shadow border rounded w-full py-2 px-3" required>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <div>
        <label for="nidn" class="block font-bold mb-2">NIDN</label>
        <input type="text" name="nidn" id="nidn" value="{{ old('nidn', $lecturer->nidn ?? '') }}" class="shadow border rounded w-full py-2 px-3">
    </div>
    <div>
        <label for="nik" class="block font-bold mb-2">NIK</label>
        <input type="text" name="nik" id="nik" value="{{ old('nik', $lecturer->nik ?? '') }}" class="shadow border rounded w-full py-2 px-3">
    </div>
    <div>
        <label for="nbm" class="block font-bold mb-2">NBM</label>
        <input type="text" name="nbm" id="nbm" value="{{ old('nbm', $lecturer->nbm ?? '') }}" class="shadow border rounded w-full py-2 px-3">
    </div>
</div>
<div class="mb-4">
    <label for="expertise" class="block font-bold mb-2">Bidang Ilmu</label>
    <input type="text" name="expertise" id="expertise" value="{{ old('expertise', $lecturer->expertise ?? '') }}" class="shadow border rounded w-full py-2 px-3">
</div>

{{-- RELASI FAKULTAS & PRODI --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="faculty_id" class="block font-bold mb-2">Fakultas</label>
        <select name="faculty_id" id="faculty_id" class="shadow border rounded w-full py-2 px-3">
            <option value="">-- Pilih Fakultas --</option>
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}" {{ (old('faculty_id', $lecturer->faculty_id ?? '') == $faculty->id) ? 'selected' : '' }}>
                    {{ $faculty->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="study_program_id" class="block font-bold mb-2">Homebase (Program Studi)</label>
        <select name="study_program_id" id="study_program_id" class="shadow border rounded w-full py-2 px-3">
            <option value="">-- Pilih Program Studi --</option>
            @foreach($studyPrograms as $program)
                <option value="{{ $program->id }}" {{ (old('study_program_id', $lecturer->study_program_id ?? '') == $program->id) ? 'selected' : '' }}>
                    {{ $program->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-4">
    <label for="functional_position" class="block font-bold mb-2">Jabatan Fungsional</label>
    <input type="text" name="functional_position" id="functional_position" value="{{ old('functional_position', $lecturer->functional_position ?? '') }}" class="shadow border rounded w-full py-2 px-3">
</div>

{{-- FOTO & LINK --}}
<div class="mb-4">
    <label for="photo" class="block font-bold mb-2">Foto</label>
    @if(isset($lecturer) && $lecturer->photo)
        <img src="{{ Storage::url($lecturer->photo) }}" class="h-24 w-auto rounded-lg mb-2">
    @endif
    <input type="file" name="photo" id="photo" class="shadow border rounded w-full py-2 px-3">
    <p class="text-xs text-gray-600 mt-1">Saran: Lebar 364px, Tinggi 364px, Maks 1MB.</p>
</div>
<div class="border-t pt-6 mt-6">
    <h3 class="font-bold mb-4 text-gray-700">Link Eksternal (Opsional)</h3>
    <div class="space-y-4">
        <div><label for="link_pddikti" class="block font-bold mb-2 text-sm">LINK PDDIKTI</label><input type="url" name="link_pddikti" value="{{ old('link_pddikti', $lecturer->link_pddikti ?? '') }}" class="shadow border rounded w-full py-2 px-3"></div>
        <div><label for="link_sinta" class="block font-bold mb-2 text-sm">LINK SINTA</label><input type="url" name="link_sinta" value="{{ old('link_sinta', $lecturer->link_sinta ?? '') }}" class="shadow border rounded w-full py-2 px-3"></div>
        <div><label for="link_scholar" class="block font-bold mb-2 text-sm">LINK SCHOLAR</label><input type="url" name="link_scholar" value="{{ old('link_scholar', $lecturer->link_scholar ?? '') }}" class="shadow border rounded w-full py-2 px-3"></div>
    </div>
</div>

{{-- TOMBOL AKSI --}}
<div class="flex items-center mt-6">
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Save</button>
    <a href="{{ route('admin.lecturers.index') }}" class="ml-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Cancel</a>
</div>
</form>

</div>