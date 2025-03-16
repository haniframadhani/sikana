<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'create account']);
        Permission::create(['name' => 'delete account']);
        Permission::create(['name' => 'archive account']);
        Permission::create(['name' => 'search global']);
        Permission::create(['name' => 'search region']);
        Permission::create(['name' => 'export excel']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['id' => Str::uuid(), 'name' => 'admin'])->givePermissionTo(['create account', 'delete account', 'archive account', 'export excel']);
        Role::create(['id' => Str::uuid(), 'name' => 'anggota']);
        Role::create(['id' => Str::uuid(), 'name' => 'pimpinan-pusat'])->givePermissionTo(['search global', 'export excel']);
        Role::create(['id' => Str::uuid(), 'name' => 'pimpinan-wilayah'])->givePermissionTo(['search region', 'export excel']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}