<?php

namespace App\Services\API\Admin\Users;

use App\Http\Requests\API\Admin\Users\StoreUserRequest;
use App\Http\Requests\API\Admin\Users\UpdateUserRequest;
use App\Http\Resources\API\Admin\Users\RoleListResource;
use App\Http\Resources\API\Admin\Users\UserEditResource;
use App\Http\Resources\API\Admin\Users\UserListResource;
use App\Interfaces\API\Admin\Users\UsersInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersService implements UsersInterface
{
    public function getAll(Request $request)
    {
        $users = User::with('roles')->paginate($request->item_per_page);

        if ($request->search) {
            $users = User::with('roles')
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->paginate($request->item_per_page);
        }
        if ($users) {
            return  UserListResource::collection(User::with('roles')->get());
        }
        return response()->json(['message' => 'No user found'], 200);
    }

    public function getAllRoles()
    {
        $roles = Role::all();
        if ($roles) {
            return RoleListResource::collection(Role::all());
        }
        return response()->json(['message' => 'No role found'], 200);
    }
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->except('roles'));
            $user->roles()->sync($request->roles);
            DB::commit();
            return  response()->json(['message' => 'User created successfully.'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return  response()->json($th->getMessage(), 201);
        }
    }
    public function edit(int $id)
    {
        $role = User::with('roles')->find($id);
        if ($role) {
            return new UserEditResource(User::with('roles')->whereId($id)->first());
        } else {
            return response()->json(['message' => 'User not found'], 201);
        }
    }
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = User::find($id);
        if ($user) {
            $data = ['name' => $request->name, 'email' => $request->email];
            if ($request->password) {
                $data['password'] = $request->password;
            }
            $user->update($data);
            $user->roles()->sync($request->roles);
            return  response()->json(['message' => 'User updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 201);
        }
    }
    public function destroy(int $id)
    {
        $user = User::with('roles')->whereId($id)->first();
        if ($user) {
            $user->roles()->detach();
            $user->delete();
            return  response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 201);
        }
    }
}
