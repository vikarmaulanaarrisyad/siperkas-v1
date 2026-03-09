<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // reset cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // buat permission
        $permissions = [
            'buat pengajuan',
            'lihat pengajuan',
            'verifikasi pengajuan',
            'kelola jenis berkas',
            'kelola user'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // buat role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // assign permission ke role admin
        $admin->givePermissionTo([
            'verifikasi pengajuan',
            'kelola jenis berkas',
            'kelola user',
            'lihat pengajuan'
        ]);

        // assign permission ke role user
        $user->givePermissionTo([
            'buat pengajuan',
            'lihat pengajuan'
        ]);
    }
}
