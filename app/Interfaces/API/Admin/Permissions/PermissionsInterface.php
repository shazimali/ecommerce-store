<?php

namespace App\Interfaces\API\Admin\Permissions;

use App\Http\Requests\API\Admin\Permissions\StorePermissionRequest;
use App\Http\Requests\API\Admin\Permissions\UpdatePermissionRequest;

interface PermissionsInterface
{
    public function getAllPermissions();
    public function store(StorePermissionRequest $request);
    public function edit(int $id);
    public function update(UpdatePermissionRequest $request, int $id);
    public function destroy(int $id);
}
