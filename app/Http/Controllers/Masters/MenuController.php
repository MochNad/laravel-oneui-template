<?php

namespace App\Http\Controllers\Masters;

use App\DataTables\Masters\MenuDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Menu\OrderMenuRequest;
use App\Http\Requests\Masters\Menu\StoreMenuRequest;
use App\Http\Requests\Masters\Menu\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    protected $modules = ['menus', 'menus.dashboard', 'menus.landing'];
    protected $tableId = 'menu-table';
    protected $modalId;
    protected $type;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->type = $request->segment(2);
        $this->modalId = 'menu-' . $this->type . '-modal';
    }

    public function index()
    {
        $dataTable = new MenuDataTable($this->type);
        return $dataTable->render('pages.masters.menu.index', ['type' => $this->type]);
    }

    public function order(OrderMenuRequest $request, Menu $menu): JsonResponse
    {
        DB::beginTransaction();
        try {
            $move = $request->input('move');
            $parentId = $menu->parent_id;

            $query = Menu::where('parent_id', $parentId)
                ->where('type', $this->type);

            $menus = $query->orderBy('order')->get();

            $currentIndex = $menus->search(function ($item) use ($menu) {
                return $item->id === $menu->id;
            });

            if ($currentIndex === false) {
                throw new \Exception('Menu not found in list');
            }

            if ($move === 'up' && $currentIndex > 0) {
                $swapIndex = $currentIndex - 1;
            } elseif ($move === 'down' && $currentIndex < $menus->count() - 1) {
                $swapIndex = $currentIndex + 1;
            } else {
                throw new \Exception('Invalid move operation');
            }

            $swapMenu = $menus[$swapIndex];

            $currentOrder = $menu->order;
            $menu->order = $swapMenu->order;
            $swapMenu->order = $currentOrder;

            $menu->save();
            $swapMenu->save();

            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
            ], 'Menu order updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreMenuRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $parentId = $validated['parent_id'];
            $name = strtolower($validated['name']);

            if ($parentId !== null && $validated['title'] !== null) {
                throw new \Exception('Choose either title or parent');
            }

            if ($parentId) {
                $parentModule = Menu::where('id', $parentId)->where('type', $this->type)->value('module');
                $parentSlug = Menu::where('id', $parentId)->where('type', $this->type)->value('slug');
                $url = Menu::where('id', $parentId)->where('type', $this->type)->value('url');
                $order = Menu::where('parent_id', $parentId)->where('type', $this->type)->max('order') + 1;
            } else {
                $parentModule = null;
                $parentSlug = null;
                $url = null;
                $order = Menu::whereNull('parent_id')->where('type', $this->type)->max('order') + 1;
            }

            $validated = [
                "title" => $validated['title'] !== null ? strtolower($validated['title']) : null,
                "name" => $name,
                "module" => $parentModule ? strtolower("{$parentModule}.{$name}") : strtolower($name),
                "slug" => $parentSlug ? strtolower("{$parentSlug}-{$name}") : strtolower($name),
                "url" => $url ? strtolower("{$url}/{$name}") : strtolower($name),
                "icon" => strtolower($validated['icon']),
                "parent_id" => $parentId,
                "order" => $order,
                "type" => $this->type,
            ];

            $menu = Menu::create($validated);

            DB::commit();
            return jsonTable([
                'tableId' => "#{$this->tableId}",
                'modalId' => "#create-{$this->modalId}",
            ], "Menu {$menu->name} created successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(Menu $menu): JsonResponse
    {
        return response()->json(array_merge(
            $menu->only('name', 'title'),
            [
                'icon' => [
                    'id' => $menu->icon,
                    'text' => implode('-', array_slice(explode('-', $menu->icon), 1)),
                ],
                'parent_id' => [
                    'id' => $menu->parent_id,
                    'text' => $menu->parent_id ? ucwords($menu->parent->name) : null,
                ],
            ]
        ));
    }

    public function update(UpdateMenuRequest $request, Menu $menu): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $parentId = $validated['parent_id'];
            $name = strtolower($validated['name']);

            if ($parentId !== null && $validated['title'] !== null) {
                throw new \Exception('Choose either title or parent');
            }

            if ($parentId) {
                $parentModule = Menu::where('id', $parentId)->where('type', $this->type)->value('module');
                $parentSlug = Menu::where('id', $parentId)->where('type', $this->type)->value('slug');
                $url = Menu::where('id', $parentId)->where('type', $this->type)->value('url');
                $order = $parentId === $menu->parent_id ? $menu->order : Menu::where('parent_id', $parentId)->where('type', $this->type)->max('order') + 1;
            } else {
                $parentModule = null;
                $parentSlug = null;
                $url = null;
                $order = $parentId === $menu->parent_id ? $menu->order : Menu::whereNull('parent_id')->where('type', $this->type)->max('order') + 1;
            }

            $validated = [
                "title" => $validated['title'] !== null ? strtolower($validated['title']) : null,
                "name" => $name,
                "module" => $parentModule ? strtolower("{$parentModule}.{$name}") : strtolower($name),
                "slug" => $parentSlug ? strtolower("{$parentSlug}/{$name}") : strtolower($name),
                "url" => $url ? strtolower("{$url}/{$name}") : strtolower($name),
                "icon" => strtolower($validated['icon']),
                "parent_id" => $parentId,
                "order" => $order,
                "type" => $this->type,
            ];

            $menu->update($validated);

            DB::commit();
            return jsonTable([
                'tableId' => "#{$this->tableId}",
                'modalId' => "#edit-{$this->modalId}",
            ], "Menu {$menu->name} updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Menu $menu): JsonResponse
    {
        DB::beginTransaction();
        try {
            $menu->delete();
            DB::commit();
            return jsonTable([
                'tableId' => "#{$this->tableId}",
            ], "Menu {$menu->name} deleted successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
