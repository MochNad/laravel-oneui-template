<?php

namespace App\Http\Controllers\Masters\Authorizations;

use App\DataTables\Masters\Authorizations\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Authorizations\Role\StoreRoleRequest;
use App\Http\Requests\Masters\Authorizations\Role\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $modules = ['authorizations.role'];
    protected $tableId = 'role-table';
    protected $modalId = 'role-modal';

    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('pages.masters.authorizations.role.index');
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $role = Role::create(['name' => strtolower($request->validated()['name'])]);
            $role->syncPermissions($request->permissions);

            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
                'modalId' => '#create-' . $this->modalId,
            ], 'Role ' . $role->name . ' created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(Role $role): JsonResponse
    {
        return response()->json([...collect($role->toArray())->only('name')->toArray()]);
    }

    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        DB::beginTransaction();
        try {
            $role->update(['name' => strtolower($request->validated()['name'])]);
            $role->syncPermissions($request->permissions);

            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
                'modalId' => '#edit-' . $this->modalId,
            ], 'Role ' . $role->name . ' updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Role $role): JsonResponse
    {
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
            ], 'Role ' . $role->name . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editPermission(Role $role): JsonResponse
    {
        $allPermissions = Permission::all()->pluck('name')->toArray();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = [];
        foreach ($allPermissions as $permission) {
            $parts = explode('-', $permission);
            $basePermission = $parts[0];
            $accessType = $parts[1] ?? 'view';
            if (!isset($permissions[$basePermission])) {
                $permissions[$basePermission] = [
                    'view' => false,
                    'create' => false,
                    'read' => false,
                    'update' => false,
                    'delete' => false,
                ];
            }
            if (in_array($permission, $rolePermissions)) {
                $permissions[$basePermission][$accessType] = true;
            }
        }

        $response = array_merge(
            collect($role->toArray())->only('name')->toArray(),
            ['permissions' => $permissions]
        );
        return response()->json($response);
    }

    public function updatePermission(Request $request, Role $role): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token', '_method']);
            $data = array_combine(
                array_map(fn ($key) => str_replace('_', '.', $key), array_keys($data)),
                $data
            );
            $permissions = array_keys(array_filter($data, fn ($value) => $value === 'true'));
            $permissions = array_map(function ($permission) {
                return str_replace('-view', '', $permission);
            }, $permissions);
            $role->syncPermissions($permissions);
            DB::commit();
            return jsonTable([
                'tableId' => '#' . $this->tableId,
                'modalId' => '#edit-permission-' . $this->modalId,
            ], 'Role ' . $role->name . ' permissions updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
