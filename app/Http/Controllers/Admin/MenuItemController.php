<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function create(Menu $menu)
    {
        $parentItems = $menu->items;
        $pages = Page::where('active', true)->orderBy('title')->get();
        return view('admin.menu-items.create', compact('menu', 'parentItems', 'pages'));
    }

    public function store(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'active' => 'required|boolean',
        ]);
        
        $menu->items()->create($validated);

        return redirect()->route('admin.menus.show', $menu)->with('success', 'Item menu berhasil ditambahkan.');
    }

    public function edit(MenuItem $menuItem)
    {
        $menu = $menuItem->menu;
        $parentItems = $menu->items()->where('id', '!=', $menuItem->id)->get();
        $pages = Page::where('active', true)->orderBy('title')->get();
        return view('admin.menu-items.edit', compact('menuItem', 'menu', 'parentItems', 'pages'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'sort_order' => 'required|integer',
            'active' => 'required|boolean',
        ]);
        
        $menuItem->update($validated);
        return redirect()->route('admin.menus.show', $menuItem->menu_id)->with('success', 'Item menu berhasil diperbarui.');
    }
    
    public function destroy(MenuItem $menuItem)
    {
        $menu_id = $menuItem->menu_id;
        $menuItem->delete();
        return redirect()->route('admin.menus.show', $menu_id)->with('success', 'Item menu berhasil dihapus.');
    }
}
