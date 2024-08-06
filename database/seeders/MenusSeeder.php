<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(public_path('json/menus.json'));

        $menus = json_decode($json, true);

        foreach ($menus as $index => $menu) {
            $menu['order'] = $index + 1;
            $root = Menu::create(collect($menu)->except('childrens')->toArray());
            $this->insertChildrens($menu, $root);
        }
    }

    public function insertChildrens(array $menuData, Menu $rootMenu)
    {
        if (!empty($menuData['childrens'])) {
            foreach ($menuData['childrens'] as $index => $children) {
                $children['parent_id'] = $rootMenu->id;
                $children['order'] = $index + 1;
                $res = Menu::create(collect($children)->except('childrens')->toArray());
                if (!empty($children['childrens'])) {
                    $this->insertChildrens($children, $res);
                }
            }
        }
    }
}
