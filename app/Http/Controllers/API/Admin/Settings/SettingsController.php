<?php

namespace App\Http\Controllers\API\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Settings\StoreSettingRequest;
use App\Http\Requests\API\Admin\Settings\UpdateSettingRequest;
use App\Services\API\Admin\Settings\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {
        return $this->settingsService->getAll($request);
    }

    public function store(StoreSettingRequest $request)
    {
        return $this->settingsService->store($request);
    }

    public function edit(int $id)
    {
        return $this->settingsService->edit($id);
    }

    public function update(UpdateSettingRequest $request, int $id)
    {
        return $this->settingsService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->settingsService->destroy($id);
    }
}
