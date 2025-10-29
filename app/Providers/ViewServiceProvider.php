<?php

namespace App\Providers;

use App\Models\Faculty; // <-- TAMBAHKAN INI
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bagikan data ke layout frontend dan admin
        View::composer(['layouts.frontend', 'layouts.admin'], function ($view) {
            
            $siteSettings = Setting::pluck('value', 'key');
            
            $headerMenu = Menu::where('location', 'header')
                              ->with('items.children')
                              ->first();
            
            // --- INI BAGIAN YANG DIPERBARUI ---
            
            // 1. Ambil Menu Footer (untuk "Link Terkait")
            $footerMenu = Menu::where('location', 'footer')
                              ->with('items')
                              ->first();
            
            // 2. Ambil Data Fakultas (untuk kolom "Fakultas")
            $footerFaculties = Faculty::where('active', true)->orderBy('name')->get();

            // 4. Kirim semua data ke view
            $view->with(compact('siteSettings', 'headerMenu', 'footerMenu', 'footerFaculties'));
        });
    }
}

