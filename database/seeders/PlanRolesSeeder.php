<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PlanRolesSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Basic User — sirf dashboard
        $basic = Role::firstOrCreate(['name' => 'Basic User']);
        $basic->syncPermissions([]);

        // Pro Business User — products + categories CRUD
        $pro = Role::firstOrCreate(['name' => 'Pro Business User']);
        $pro->syncPermissions([
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
        ]);

        // Enterprise User — sab kuch
        $enterprise = Role::firstOrCreate(['name' => 'Enterprise User']);
        $enterprise->syncPermissions(Permission::all());
    }
}
