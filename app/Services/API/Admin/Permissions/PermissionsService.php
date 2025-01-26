<?php

namespace App\Services\API\Admin\Permissions;

use App\Http\Requests\API\Admin\Permissions\StorePermissionRequest;
use App\Http\Requests\API\Admin\Permissions\UpdatePermissionRequest;
use App\Http\Resources\API\Admin\Permissions\PermissionListResource;
use App\Interfaces\API\Admin\Permissions\PermissionsInterface;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class PermissionsService implements PermissionsInterface
{
    public function getAllPermissions()
    {
        $permission = Permission::all();
        if ($permission) {
            return PermissionListResource::collection(Permission::all());
        }
        return response()->json(['message' => 'No permissions found'], 200);
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());

        if ($permission) {
            return response()->json(['message' => 'Permission Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Permission Not Stored '], 500);
        }
    }

    public function edit(int $id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            // make a resource which name should be PermissionEditResource     id, name, key
            // return new RoleEditResource($permission);

            //ROME This code 

            // return  response()->json([
            //     'message' => 'Permission Fetch Successfully',
            //     'data' => [
            //         'name' => $permission->name,
            //         'key' => $permission->key

            //     ]
            // ]);
        } else {
            return response()->json(['message' => 'Permission not found'], 404);
        }
    }

    public function update(UpdatePermissionRequest $request, int $id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $data = [
                'name' => $request->name,
                'key' => $request->key,
            ];
            $permission->save($data);
            return response()->json(['message' => 'Permission Updated Successfully'], 200);
        } else {
            return response()->json(['message' => 'Permission not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['message', 'Permission does not exist'], 404);
        } else {
            $permission->delete();
            return response()->json(['message', 'Permission Deleted Successfully'], 200);
        }
    }
}
