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

    public function index()
    {

        return $this->permissionsService->getAllPermissions();
    }

    public function store(StorePermissionRequest $request)
    {

        return $this->permissionsService->store($request);
    }

    public function edit($id)
    {

        return $this->permissionsService->edit($id);
    }

    public function update(UpdatePermissionRequest $request, int $id)
    {
        return $this->permissionsService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->permissionsService->destroy($id);
    }
}
