<?php

namespace App\Http\Controllers\Masters\Authorizations;

use App\DataTables\Masters\Authorizations\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Authorizations\Permission\StorePermissionRequest;
use App\Http\Requests\Masters\Authorizations\Permission\UpdatePermissionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $modules = ['authorizations.permission'];
    protected $tableId = 'permission-table';
    protected $modalId = 'permission-modal';
    protected $accessTypes = ['create', 'read', 'update', 'delete'];

    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('pages.masters.authorizations.permission.index');
    }

    public function store(StorePermissionRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $name = strtolower($validatedData['name']);
            $accessTypes = $this->getAccessTypes($validatedData);
            $enabledAccessTypes = array_keys(array_filter($accessTypes));
            $permissions = array_merge(
                [[
                    'name' => $name,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]],
                array_map(function ($access) use ($name) {
                    return [
                        'name' => "{$name}-{$access}",
                        'guard_name' => 'web',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $enabledAccessTypes)
            );

            Permission::insert($permissions);
            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
                'modalId' => '#create-' . $this->modalId,
            ], "Permission {$name} created successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(Permission $permission): JsonResponse
    {
        return response()->json([...collect($permission->toArray())->only('name'), 'access' => [
            'create' => Permission::where('name', "{$permission->name}-create")->exists(),
            'read' => Permission::where('name', "{$permission->name}-read")->exists(),
            'update' => Permission::where('name', "{$permission->name}-update")->exists(),
            'delete' => Permission::where('name', "{$permission->name}-delete")->exists(),
        ]]);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $newPrefix = strtolower($validatedData['name']);
            $oldPrefix = $permission->name;
            $permission->update(['name' => $newPrefix]);
            $activeAccessTypes = array_filter(
                array_intersect_key($validatedData, array_flip($this->accessTypes))
            );
            foreach ($this->accessTypes as $type) {
                $oldPermissionName = "{$oldPrefix}-{$type}";
                $newPermissionName = "{$newPrefix}-{$type}";

                if (isset($activeAccessTypes[$type]) && $activeAccessTypes[$type]) {
                    Permission::where('name', $oldPermissionName)
                        ->update(['name' => $newPermissionName]);
                } else {
                    Permission::where('name', $oldPermissionName)->delete();
                }
            }
            foreach ($activeAccessTypes as $type => $isActive) {
                if ($isActive) {
                    if (!Permission::where('name', "{$newPrefix}-{$type}")->exists()) {
                        Permission::create([
                            'name' => "{$newPrefix}-{$type}",
                            'guard_name' => 'web',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
                'modalId' => '#edit-' . $this->modalId,
            ], "Permission {$newPrefix} updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Permission $permission): JsonResponse
    {
        DB::beginTransaction();
        try {
            $prefix = explode('-', $permission->name)[0];
            $permission->delete();
            Permission::where('name', 'like', "{$prefix}-%")->delete();

            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
            ], "Permission {$prefix} and its access permissions deleted successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getAccessTypes(array $validatedData): array
    {
        return array_merge(
            array_fill_keys($this->accessTypes, false),
            array_intersect_key($validatedData, array_flip($this->accessTypes))
        );
    }
}
