<?php

namespace App\Http\Controllers\API\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Roles\StoreRoleRequest;
use App\Http\Requests\API\Admin\Roles\UpdateRoleRequest;
use App\Services\API\Admin\Roles\RolesService;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public $rolesService;
    
    public function __construct(RolesService $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function index(Request $request)
    {
        $this->authorize('role_access');
        return  $this->rolesService->getAll($request);
    }

    public function create()
    {
        $this->authorize('role_create');

        return  $this->rolesService->create();
    }
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('role_create');

        return $this->rolesService->store($request);
    }
    public function update(UpdateRoleRequest $request,int $id)
    {
        $this->authorize('role_edit');
           
        return $this->rolesService->update($request,$id);
    }
    public function edit(int $id)
    {
        $this->authorize('role_edit');

        return $this->rolesService->edit($id);
        
    }
    
    public function destroy(int $id)
    {
        $this->authorize('role_delete');

        return $this->rolesService->destroy($id);
    }
}
