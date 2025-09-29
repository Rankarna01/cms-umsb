<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat semua permissions
        Permission::create(['name' => 'kelola berita']);
        Permission::create(['name' => 'kelola halaman']);
        Permission::create(['name' => 'kelola agenda']);
        Permission::create(['name' => 'kelola pengumuman']);
        Permission::create(['name' => 'kelola slider']);
        Permission::create(['name' => 'kelola galeri']);
        Permission::create(['name' => 'kelola dokumen']);
        Permission::create(['name' => 'kelola dosen']);
        Permission::create(['name' => 'kelola data master']); // Untuk Fakultas & Prodi
        Permission::create(['name' => 'kelola menu']);
        Permission::create(['name' => 'kelola pengaturan']);
        Permission::create(['name' => 'kelola user']); // Permission khusus

        // Buat role Admin
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo([
            'kelola berita',
            'kelola halaman',
            'kelola agenda',
            'kelola pengumuman',
            'kelola slider',
            'kelola galeri',
            'kelola dokumen',
            'kelola dosen',
            'kelola data master',
            'kelola menu',
            'kelola pengaturan',
        ]);

        // Buat role Super Admin
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        // Super Admin bisa melakukan semuanya
        $superAdminRole->givePermissionTo(Permission::all());
    }
}