<?php

namespace App\Http\Controllers\API\Admin\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Permissions\StorePermissionRequest;
use App\Http\Requests\API\Admin\Permissions\UpdatePermissionRequest;
use App\Services\API\Admin\Permissions\PermissionsService;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public $permissionsService;

    public function __construct(PermissionsService $permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    public function index(Request $request)
    {
        $this->authorize('permission_access');
        return $this->permissionsService->getAllPermissions($request);
    }

    public function store(StorePermissionRequest $request)
    {

        $this->authorize('permission_create');
        return $this->permissionsService->store($request);
    }

    public function edit($id)
    {
        $this->authorize('permission_edit');
        return $this->permissionsService->edit($id);
    }

    public function update(UpdatePermissionRequest $request, int $id)
    {
        $this->authorize('permission_edit');
        return $this->permissionsService->update($request, $id);
    }

    public function destroy($id)
    {
        $this->authorize('permission_delete');
        return $this->permissionsService->destroy($id);
    }
}
