<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'username' => 'admina',
            'name' => 'Admin A',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('admin');

        $admin2 = User::create([
            'username' => 'adminb',
            'name' => 'Admin B',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $admin2->assignRole('admin');

        $user1 = User::create([
            'username' => 'mhs1',
            'name' => 'Mahasiswa 1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user1->assignRole('user');

        $user2 = User::create([
            'username' => 'mhs2',
            'name' => 'Mahasiswa 2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user2->assignRole('user');
    }
}
