<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Setting\SettingRepositoryInterface;
use Illuminate\Http\Request;
use App\Contracts\DatabaseExportServiceInterface;

class SettingController extends Controller
{
    protected $settingRepository;
    protected $databaseExportService;

    public function __construct(SettingRepositoryInterface $settingRepository, DatabaseExportServiceInterface $databaseExportService)
    {
        $this->settingRepository = $settingRepository;
        $this->databaseExportService = $databaseExportService;
    }

    public function index()
    {
        $settings = $this->settingRepository->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $this->settingRepository->updateSettings($data);

        return redirect()->back()->with('success', 'Cài đặt đã được cập nhật thành công.');
    }
    // Export database using service with error handling
    public function export()
    {
        try {
            return $this->databaseExportService->export();
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}

