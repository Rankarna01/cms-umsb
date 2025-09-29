<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Role tidak lagi dibutuhkan di sini
// use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create'); // Hanya tampilkan view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // 'roles' => 'required|array' // HAPUS INI
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        // $user->assignRole($validated['roles']); // HAPUS INI

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user')); // Hanya kirim data user
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            // 'roles' => 'required|array' // HAPUS INI
        ]);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();
        // $user->syncRoles($validated['roles']); // HAPUS INI

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function editPermissions(User $user)
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode(' ', $item->name)[1];
        });
        $userPermissions = $user->permissions->pluck('name')->toArray();

        return view('admin.users.permissions', compact('user', 'permissions', 'userPermissions'));
    }

    public function updatePermissions(Request $request, User $user)
    {

        $permissions = $request->input('permissions', []);
        $user->syncPermissions($permissions);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        return redirect()->route('admin.users.index')->with('success', 'Izin akses untuk ' . $user->name . ' berhasil diperbarui.');
    }
}
