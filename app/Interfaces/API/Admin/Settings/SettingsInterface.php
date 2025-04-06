<?php

namespace App\Interfaces\API\Admin\Settings;

use App\Http\Requests\API\Admin\Settings\StoreSettingRequest;
use App\Http\Requests\API\Admin\Settings\UpdateSettingRequest;
use Illuminate\Http\Request;

interface SettingsInterface
{
    public function getAll(Request $request);
    public function getAllCountries();
    public function store(StoreSettingRequest $request);
    public function edit(int $id);
    public function update(UpdateSettingRequest $request, int $id);
    public function destroy(int $id);
}
