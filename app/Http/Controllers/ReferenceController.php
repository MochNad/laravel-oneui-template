<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ReferenceController extends Controller
{
    private function formatSelect2(Collection|array $data, string $key = 'id', string $value = "name", int $limit = 10, callable $callbackLabel = null)
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }
        $result = [];
        foreach ($data as $item) {
            $result[] = [
                "id" => $item[$key],
                "text" => $callbackLabel ? $callbackLabel($item) : $item[$value]
            ];
        }

        return collect($result)->slice(0, $limit)->values();
    }

    public function icon(Request $request)
    {
        $search = $request->get('q');
        $limit = $request->get('limit', 10);
        $iconSource = 'si';
        $iconPrefix = 'si-';

        $filePath = public_path('assets/css/oneui.min.css');
        $cssContent = file_get_contents($filePath);

        preg_match_all('/\.' . $iconPrefix . '([a-z0-9-]+):before/', $cssContent, $matches);

        $icons = collect($matches[1])->map(function ($iconName) use ($iconSource, $iconPrefix) {
            return ['id' => $iconSource . ' ' . $iconPrefix . $iconName, 'name' => $iconName];
        });

        if ($search) {
            $icons = $icons->filter(function ($icon) use ($search) {
                return strpos($icon['name'], $search) !== false;
            });
        }

        $icons = $icons->sortBy('name')->values();

        return $this->formatSelect2($icons, 'id', 'name', $limit);
    }

    public function menu(Request $request)
    {
        $search = $request->get('q');
        $limit = $request->get('limit', 10);

        $menus = Menu::where('parent_id', null)->get()->map(function ($menu) {
            return ['id' => $menu->id, 'name' => ucwords($menu->name)];
        });

        if ($search) {
            $menus = collect($menus)->filter(function ($menu) use ($search) {
                return strpos($menu['name'], $search) !== false;
            });
        }

        $menus = collect($menus)->sortBy('name')->values();

        return $this->formatSelect2($menus, 'id', 'name', $limit);
    }

    public function role(Request $request)
    {
        $search = $request->get('q');
        $limit = $request->get('limit', 10);

        $roles = Role::all()->map(function ($role) {
            return ['id' => $role->id, 'name' => $role->name];
        });

        if ($search) {
            $roles = collect($roles)->filter(function ($role) use ($search) {
                return strpos($role['name'], $search) !== false;
            });
        }

        $roles = collect($roles)->sortBy('name')->values();

        return $this->formatSelect2($roles, 'id', 'name', $limit);
    }
}
