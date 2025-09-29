<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil semua setting dan ubah menjadi format key => value
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = $request->except('_token');

        foreach ($settings as $key => $value) {
            // Cek jika ada file upload
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('public/settings');
                $value = $path;

                // Hapus file lama jika ada
                $old_file = Setting::where('key', $key)->first()->value;
                if ($old_file) {
                    Storage::delete($old_file);
                }
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
