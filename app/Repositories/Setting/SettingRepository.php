<?php

namespace App\Repositories\Setting;

use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    public function getSettings()
    {
        return Setting::first();
    }

    public function updateSettings(array $data)
    {
        $setting = Setting::first();
        if (!$setting) {
            return Setting::create($data);
        }
        $setting->update($data);
        return $setting;
    }
}
