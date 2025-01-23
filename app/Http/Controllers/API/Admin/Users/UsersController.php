<?php

namespace App\Http\Controllers\API\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Users\StoreUserRequest;
use App\Http\Requests\API\Admin\Users\UpdateUserRequest;
use App\Services\API\Admin\Users\UsersService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index(Request $request)
    {
        $this->authorize('user_access');
        return  $this->usersService->getAll($request);
    }

    public function getAllRoles()
    {
        $this->authorize('user_create');

        return  $this->usersService->getAllRoles();
    }
    public function store(StoreUserRequest $request)
    {
        $this->authorize('user_create');

        return $this->usersService->store($request);
    }
    public function update(UpdateUserRequest $request, int $id)
    {
        $this->authorize('user_edit');

        return $this->usersService->update($request, $id);
    }
    public function edit(int $id)
    {
        $this->authorize('user_edit');

        return $this->usersService->edit($id);
    }

    public function destroy(int $id)
    {
        $this->authorize('user_delete');

        return $this->usersService->destroy($id);
    }
}
