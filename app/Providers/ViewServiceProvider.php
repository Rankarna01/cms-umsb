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
        // Bagikan data ke semua view frontend
        View::composer('layouts.frontend', function ($view) {
            
            // Query menu dengan filter 'active'
            $headerMenu = Menu::where('location', 'header')
                ->with([
                    'items' => function ($query) {
                        $query->where('active', true)->orderBy('sort_order');
                    },
                    'items.children' => function ($query) {
                        $query->where('active', true)->orderBy('sort_order');
                    }
                ])
                ->first();

            $siteSettings = Setting::pluck('value', 'key');
            
            $view->with(compact('headerMenu', 'siteSettings'));
        });
    }
}