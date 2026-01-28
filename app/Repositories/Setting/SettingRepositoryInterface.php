<?php

namespace App\Repositories\Setting;

interface SettingRepositoryInterface
{
    public function getSettings();
    public function updateSettings(array $data);
}
