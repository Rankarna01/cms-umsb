<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            return explode(' ', $item->name)[1];
        });
        
        // --- TAMBAHKAN INI ---
        $users = User::orderBy('name')->get(); 
        
        // --- TAMBAHKAN $users KE COMPACT ---
        return view('admin.roles.create', compact('permissions', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'users' => 'nullable|array', // Tambah validasi
        ]);

        $role = Role::create(['name' => $validated['name']]);
        
        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }
        
        if (!empty($validated['users'])) {
            $users = User::whereIn('id', $validated['users'])->get();
            foreach ($users as $user) {
                $user->syncRoles($role->name); // Berikan role ini ke user
            }
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($item) {
            return explode(' ', $item->name)[1];
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        // --- TAMBAHKAN INI ---
        $users = User::orderBy('name')->get();

        // --- TAMBAHKAN $users KE COMPACT ---
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions', 'users'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'users' => 'nullable|array', // Tambah validasi
        ]);

        $role->update(['name' => $validated['name']]);
        
        // Sinkronkan izin
        $role->syncPermissions($request->input('permissions', []));
        
        // Sinkronkan user
        $role->users()->sync($request->input('users', []));

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui.');
    }
}
