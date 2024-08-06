<?php

namespace App\Http\Controllers\Managements;

use App\DataTables\Managements\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Managements\User\StoreUserRequest;
use App\Http\Requests\Managements\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use function Termwind\render;

class UserController extends Controller
{
    protected $modules = ['user'];
    protected $tableId = 'user-table';
    protected $modalId = 'user-modal';

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('pages.managements.user.index');
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $role = Role::findOrFail($data['role_id']);

            $validated = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(config('app.default.password')),
            ];

            $user = User::create($validated);
            $user->assignRole($role);
            $user->sendEmailVerificationNotification();

            DB::commit();
            return jsonTable([
                'tableId' => "#{$this->tableId}",
                'modalId' => "#create-{$this->modalId}",
            ], "User {$user->name} created successfully and verification email sent.");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(User $user)
    {
        return response()->json(array_merge($user->only('name', 'email'), [
            'role_id' => [
                'id' => $user->roles->first()->id,
                'text' => $user->roles->first()->name,
            ],
        ]));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $role = Role::findOrFail($data['role_id']);

            $validated = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            $user->update($validated);
            $user->syncRoles($role);

            DB::commit();
            return jsonTable([
                'tableId' => "#{$this->tableId}",
                'modalId' => "#edit-{$this->modalId}",
            ], "User {$user->name} updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reset(User $user)
    {
        DB::beginTransaction();
        try {
            $user->password = Hash::make(config('app.default.password'));
            $user->save();

            DB::commit();
            return jsonTable([
                'tableId' => "#{$this->tableId}",
            ], "User {$user->name} password reset successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();

            DB::commit();
            return jsonTable([
                'tableId' => "#{$this->tableId}",
            ], "User {$user->name} deleted successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
