<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $usersData = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'anggota',
                'email' => 'anggota@mail.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'pusat',
                'email' => 'pusat@mail.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'wilayah',
                'email' => 'wilayah@mail.com',
                'password' => bcrypt('password')
            ],
        ];
        $roles = ['admin', 'anggota', 'pimpinan-pusat', 'pimpinan-wilayah'];
        $this->call([RoleSeeder::class]);
        foreach ($usersData as $index => $user) {
            $createdUser = User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('password'),
            ]);
            $createdUser->assignRole($roles[$index]);
        }
    }
}