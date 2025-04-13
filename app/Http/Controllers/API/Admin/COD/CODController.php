<?php

namespace App\Http\Controllers\API\Admin\COD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\COD\StoreCODRequest;
use App\Http\Requests\API\Admin\COD\UpdateCODRequest;
use App\Services\API\Admin\COD\CODService;
use Illuminate\Http\Request;

class CODController extends Controller
{
    public $codService;

    public function __construct(CODService $codService)
    {
        $this->codService = $codService;
    }

    public function index(Request $request)
    {
        $this->authorize('cod_access');
        return $this->codService->getAll($request);
    }

    public function getAllCountries()
    {
        return $this->codService->getAllCountries();
    }

    public function store(StoreCODRequest $request)
    {
        $this->authorize('cod_create');
        return $this->codService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('cod_edit');
        return $this->codService->edit($id);
    }

    public function update(UpdateCODRequest $request, int $id)
    {
        $this->authorize('cod_edit');
        return $this->codService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('cod_delete');
        return $this->codService->destroy($id);
    }
}
