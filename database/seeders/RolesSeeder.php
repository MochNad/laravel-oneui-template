<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (file_exists(public_path('json/accesses.json'))) {
            $accessess = json_decode(file_get_contents(public_path('json/accesses.json')), true);
            $roles = array_values(array_unique(array_column($accessess, 'role')));
            foreach ($roles as $role) {
                Role::create(['name' => $role]);
            }
        } else {
            $roles = ['admin'];
            foreach ($roles as $role) {
                Role::create(['name' => $role]);
            }
        }
    }
}
