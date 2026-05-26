<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompleteRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Safe redirect to cleaned seeders
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
