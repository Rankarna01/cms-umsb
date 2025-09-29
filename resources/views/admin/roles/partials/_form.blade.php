{{-- ... (kode form bagian permissions) ... --}}

        {{-- TAMBAHKAN BLOK BARU INI --}}
        <div class="mb-6">
            <label class="block font-bold mb-2">Tugaskan Role ini ke User</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 border rounded-lg p-4">
                @foreach($users as $user)
                    <label class="flex items-center">
                        <input type="checkbox" name="users[]" value="{{ $user->id }}" class="form-checkbox"
                            {{ (isset($role) && $user->hasRole($role->name)) ? 'checked' : '' }}
                        >
                        <span class="ml-2">{{ $user->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        
        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">{{ isset($role) ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('admin.roles.index') }}" class="ml-4">Batal</a>
        </div>
    </form>
</div>