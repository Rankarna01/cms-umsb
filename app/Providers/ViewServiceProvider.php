<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan data ke semua view yang menggunakan layout frontend
        View::composer('layouts.frontend', function ($view) {
            $headerMenu = Menu::where('location', 'header')->with('items.children')->first();
            $siteSettings = Setting::pluck('value', 'key');
            
            $view->with(compact('headerMenu', 'siteSettings'));
        });
    }
}