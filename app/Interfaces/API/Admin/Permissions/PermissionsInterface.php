<?php

namespace App\Interfaces\API\Admin\Permissions;

use App\Http\Requests\API\Admin\Permissions\StorePermissionRequest;
use App\Http\Requests\API\Admin\Permissions\UpdatePermissionRequest;
use Illuminate\Http\Request;

interface PermissionsInterface
{
    public function getAllPermissions(Request $request);
    public function store(StorePermissionRequest $request);
    public function edit(int $id);
    public function update(UpdatePermissionRequest $request, int $id);
    public function destroy(int $id);
}
