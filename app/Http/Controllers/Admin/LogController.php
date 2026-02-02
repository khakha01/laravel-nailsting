<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\System\LogService;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * Display a listing of system logs.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.logs.index', [
            'logs' => $this->logService->getLogs($request),
            'files' => $this->logService->getLogFiles(),
            'selectedFile' => $request->get('file', 'laravel.log'),
            'levels' => ['DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY']
        ]);
    }

    /**
     * Download a log file.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function download(Request $request)
    {
        $file = $request->get('file', 'laravel.log');
        $filePath = $this->logService->getFilePath($file);

        if ($filePath) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'Log file not found.');
    }

    /**
     * Clear a log file.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $file = $request->get('file', 'laravel.log');

        if ($this->logService->clearLog($file)) {
            return redirect()->back()->with('success', 'Log file cleared successfully.');
        }

        return redirect()->back()->with('error', 'Log file not found.');
    }
}
