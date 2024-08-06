<?php

namespace Database\Seeders;

use App\Models\Access;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = Menu::all();
        $access = ['create', 'read', 'update', 'delete'];
        $permissions = [];
        $accesses = [];
        $timestamp = now();

        foreach ($menus as $menu) {
            $permissions[] = [
                'name' => $menu->module,
                'guard_name' => 'web',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
            foreach ($access as $acc) {
                $permissions[] = [
                    'name' => $menu->module . '-' . $acc,
                    'guard_name' => 'web',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
                $accesses[] = [
                    'name' => "$menu->name $acc",
                    'module' => $menu->module . '-' . $acc,
                    'menu_id' => $menu->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }
        Permission::insert($permissions);
        Access::insert($accesses);
    }
}
