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
        $this->authorize('setting_access');
        return $this->settingsService->getAll($request);
    }

    public function getAllCountries()
    {
        return $this->settingsService->getAllCountries();
    }

    public function store(StoreSettingRequest $request)
    {
        $this->authorize('setting_create');
        return $this->settingsService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('setting_edit');
        return $this->settingsService->edit($id);
    }

    public function update(UpdateSettingRequest $request, int $id)
    {
        $this->authorize('setting_edit');
        return $this->settingsService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('setting_delete');
        return $this->settingsService->destroy($id);
    }
}
