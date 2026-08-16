<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LogsController extends Controller
{
    public function __invoke()
    {
        abort_if(!auth()->user()->can('sistema.logs'), 403, 'No tienes permiso para ver los logs.');
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logPath)) {
            $file = new \SplFileObject($logPath, 'r');
            $file->seek(PHP_INT_MAX);
            $lastLine = $file->key();
            
            // Read the last 200 lines
            $linesToRead = 200;
            $startLine = max(0, $lastLine - $linesToRead);
            
            $file->seek($startLine);
            
            while (!$file->eof()) {
                $line = $file->current();
                if (trim($line)) {
                    $logs[] = $line;
                }
                $file->next();
            }
        }

        // Reverse to show latest first
        $logs = array_reverse($logs);

        return view('admin.logs', compact('logs'));
    }
}
