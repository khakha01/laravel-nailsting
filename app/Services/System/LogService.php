<?php

namespace App\Services\System;

use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class LogService
{
    /**
     * Get all log files in the storage/logs directory.
     *
     * @return array
     */
    public function getLogFiles(): array
    {
        $logPath = storage_path('logs');
        $files = File::files($logPath);

        // Sort files by modified time descending
        usort($files, function ($a, $b) {
            return $b->getMTime() <=> $a->getMTime();
        });

        return array_map(function ($file) {
            return $file->getFilename();
        }, $files);
    }

    /**
     * Get paginated logs from a specific file with filters.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getLogs(Request $request): LengthAwarePaginator
    {
        $selectedFile = $request->get('file', 'laravel.log');
        $filePath = storage_path('logs/' . $selectedFile);

        $logs = [];
        if (File::exists($filePath)) {
            $content = File::get($filePath);

            // Regex for Laravel log entries: [YYYY-MM-DD HH:MM:SS] environment.level: message
            $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*)/';
            preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $logs[] = [
                    'timestamp' => $match[1],
                    'env' => $match[2],
                    'level' => strtoupper($match[3]),
                    'message' => $match[4],
                ];
            }

            $logs = array_reverse($logs);
        }

        // Apply filters
        if ($request->filled('q')) {
            $q = $request->q;
            $logs = array_filter($logs, function ($log) use ($q) {
                return stripos($log['message'], $q) !== false || stripos($log['level'], $q) !== false;
            });
        }

        if ($request->filled('level')) {
            $level = strtoupper($request->level);
            $logs = array_filter($logs, function ($log) use ($level) {
                return $log['level'] === $level;
            });
        }

        // Pagination
        $perPage = 50;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;

        return new LengthAwarePaginator(
            array_slice($logs, $offset, $perPage),
            count($logs),
            $perPage,
            $page,
            ['path' => route('logs.index'), 'query' => $request->query()]
        );
    }

    /**
     * Clear the content of a log file.
     *
     * @param string $fileName
     * @return bool
     */
    public function clearLog(string $fileName): bool
    {
        $filePath = storage_path('logs/' . $fileName);

        if (File::exists($filePath)) {
            File::put($filePath, '');
            return true;
        }

        return false;
    }

    /**
     * Get the absolute path for a log file for downloading.
     *
     * @param string $fileName
     * @return string|null
     */
    public function getFilePath(string $fileName): ?string
    {
        $filePath = storage_path('logs/' . $fileName);
        return File::exists($filePath) ? $filePath : null;
    }
}
