<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission; // <-- PASTIKAN INI ADA
use Spatie\Permission\Models\Role;       // <-- PASTIKAN INI ADA

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function($item) {
            return explode(' ', $item->name)[1]; // Mengelompokkan berdasarkan kata kedua (berita, halaman, dll)
        });
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($item) {
            return explode(' ', $item->name)[1];
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui.');
    }
}