<?php

namespace App\Interfaces\API\Admin\Users;

use App\Http\Requests\API\Admin\Users\StoreUserRequest;
use App\Http\Requests\API\Admin\Users\UpdateUserRequest;
use Illuminate\Http\Request;

interface UsersInterface
{
    public function getAll(Request $request);
    public function getAllRoles();
    public function store(StoreUserRequest $request);
    public function edit(int $id);
    public function update(UpdateUserRequest $request, int $id);
    public function destroy(int $id);
}
