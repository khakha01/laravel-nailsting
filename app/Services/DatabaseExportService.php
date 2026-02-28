<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use App\Contracts\DatabaseExportServiceInterface;

class DatabaseExportService implements DatabaseExportServiceInterface
{
    /**
     * Execute database export and return a downloadable response.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $db = config('database.connections.mysql');
        $username = $db['username'];
        $password = $db['password'];
        $host = $db['host'];
        $database = $db['database'];
        $dumpFile = storage_path('app/backup_' . $database . '_' . date('Ymd_His') . '.sql');

        // Escape password for shell
        $escapedPassword = str_replace("'", "\\'", $password);
        $command = "mysqldump -u{$username} -p'{$escapedPassword}' -h{$host} {$database} > {$dumpFile}";

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            // Throw an exception to be handled by the controller
            throw new \RuntimeException('Export DB failed: ' . $process->getErrorOutput());
        }

        return response()->download($dumpFile)->deleteFileAfterSend(true);
    }
}
