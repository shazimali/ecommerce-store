<?php

namespace App\Services\API\Admin\Settings;

use App\Http\Requests\API\Admin\Settings\StoreSettingRequest;
use App\Http\Requests\API\Admin\Settings\UpdateSettingRequest;
use App\Http\Resources\API\Admin\Settings\SettingsEditResource;
use App\Http\Resources\API\Admin\Settings\SettingsListResource;
use App\Interfaces\API\Admin\Settings\SettingsInterface;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsService  implements SettingsInterface
{

    public function getAll(Request $request)
    {
        $setting = Setting::with('country')->get();
        if ($setting) {
            return SettingsListResource::collection($setting);
        } else {
            return response()->json(['message' => 'Setting Not found'], 200);
        }
    }

    public function store(StoreSettingRequest $request)
    {
        $setting = Setting::create($request->all());
        if ($setting) {
            return response()->json(['message' => 'Setting Stored Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Setting Not Stored '], 201);
        }
    }

    public function edit(int $id)
    {
        $setting = Setting::find($id);
        if ($setting) {
            return new SettingsEditResource($setting);
        } else {
            return response()->json(['message' => 'Setting not exist'], 201);
        }
    }

    public function update(UpdateSettingRequest $request, int $id)
    {
        $setting = Setting::find($id);
        if ($setting) {
            $data = [
                'title' => $request->title,
                'key' => $request->key,
                'value' => $request->value,
                'country_id' => $request->country_id,
            ];
            $setting->update($data);
            return response()->json(['message' => 'Settings updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Settings not found.'], 201);
        }
    }

    public function destroy(int $id)
    {
        $setting = Setting::find($id);
        if ($setting) {
            $setting->delete();
            return response()->json(['message' => 'Settings deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Settings not found.'], 201);
        }
    }
}
