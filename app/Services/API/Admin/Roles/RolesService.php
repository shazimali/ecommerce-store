<?php

namespace App\Services\API\Admin\Roles;

use App\Http\Requests\API\Admin\Roles\StoreRoleRequest;
use App\Http\Requests\API\Admin\Roles\UpdateRoleRequest;
use App\Http\Resources\API\Admin\Permissions\PermissionListResource;
use App\Http\Resources\API\Admin\Roles\RoleEditResource;
use App\Http\Resources\API\Admin\Roles\RoleListResource;
use App\Interfaces\API\Admin\Roles\RolesInterface;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesService implements RolesInterface
{
    public function getAll(Request $request)
    {
        $roles = Role::with('permissions')->paginate($request->item_per_page);

        if ($request->search) {
            $role = Role::with('permissions')->where('name', 'like', "%{$request->search}%")->paginate($request->item_per_page);
        }
        if ($roles) {
            return  RoleListResource::collection(Role::with('permissions')->get());
        }
        return response()->json(['message' => 'No roles found'], 200);
    }

    public function getAllPermissions()
    {
        $permissions = Permission::all();
        if ($permissions) {
            return PermissionListResource::collection(Permission::all());
        }
        return response()->json(['message' => 'No permissions found'], 200);
    }
    public function store(StoreRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create($request->except('permissions'));
            $role->permissions()->sync($request->permissions);
            DB::commit();
            return  response()->json(['message' => 'Role created successfully.'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return  response()->json($th->getMessage(), 201);
        }
    }
    public function edit(int $id)
    {
        $role = Role::with('permissions')->find($id);
        if ($role) {
            return new RoleEditResource(Role::with('permissions')->whereId($id)->first());
        } else {
            return response()->json(['message' => 'Role not found'], 201);
        }
    }
    public function update(UpdateRoleRequest $request, int $id)
    {
        $role = Role::find($id);
        if ($role) {
            $data = ['name' => $request->name];
            $role->update($data);
            $role->permissions()->sync($request->permissions);
            return  response()->json(['message' => 'Role updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Role not found'], 201);
        }
    }
    public function destroy(int $id)
    {
        $role = Role::with('users')->whereId($id)->first();
        if ($role) {
            $is_role_attached_with_user = RoleUser::where('role_id', $id)->first();
            if ($is_role_attached_with_user)
                return  response()->json(['message' => 'Role attached with users, can not delete.'], 201);

            $role->delete();
            return  response()->json(['message' => 'Role deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Role not found'], 201);
        }
    }
}
