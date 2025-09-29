<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    // Method `show` akan menjadi halaman utama untuk mengelola item-item di dalam menu
    public function show(Menu $menu)
    {
        return view('admin.menus.builder', compact('menu'));
    }
}
