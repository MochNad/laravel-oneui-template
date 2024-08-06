<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;

class MenuHelper
{
    public static function getMenu(string $type): array
    {
        if (Schema::hasTable('menus')) {
            $menus = Menu::with(['childrens' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
                ->where('type', $type)
                ->whereNull('parent_id')
                ->orderBy('order', 'asc')
                ->select('id', 'title', 'name', 'module', 'slug', 'icon', 'url')
                ->get()
                ->groupBy('title');

            return $menus->toArray();
        } else {
            return [];
        }
    }
}
