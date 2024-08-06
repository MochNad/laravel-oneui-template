<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AccessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();

        if (file_exists(public_path('json/accesses.json'))) {
            $accessess = json_decode(file_get_contents(public_path('json/accesses.json')), true);
            foreach ($roles as $role) {
                $relatedAccess = array_values(array_filter($accessess, fn ($access) => $access['role'] === $role->name));
                collect($relatedAccess[0]['permissions'])->chunk(100)->each(function ($permissions) use ($role) {
                    $role->givePermissionTo($permissions);
                });
            }
        } else {
            $baseAccess = ['create', 'read', 'update', 'delete'];
            $accesses = [];

            $menus = Menu::all();
            foreach ($menus as $menu) {
                $accesses[] = "$menu->module";
                foreach ($baseAccess as $access) {
                    $accesses[] = "$menu->module-$access";
                }
            }

            foreach ($roles as $role) {
                $role->givePermissionTo($accesses);
            }
        }
    }
}
