<?php

namespace App\Interfaces\Interfaces\API\Admin\Roles;

use App\Http\Requests\API\Admin\Roles\StoreRoleRequest;
use App\Http\Requests\API\Admin\Roles\UpdateRoleRequest;
use Illuminate\Http\Request;

interface RolesInterface
{
    public function getAll(Request $request);
    public function create();
    public function store(StoreRoleRequest $request);
    public function edit(int $id);
    public function update(UpdateRoleRequest $request, int $id );
    public function destroy(int $id);
}
