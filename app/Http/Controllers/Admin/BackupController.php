<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->allFiles(config('backup.backup.name'));

        $backups = [];
        foreach ($files as $file) {
            if (substr($file, -4) === '.zip') {
                $backups[] = [
                    'file_path' => $file,
                    'file_name' => str_replace(config('backup.backup.name') . '/', '', $file),
                    'file_size' => $this->humanFilesize($disk->size($file)),
                    'last_modified' => \Carbon\Carbon::createFromTimestamp($disk->lastModified($file))->format('d/m/Y h:i A'),
                ];
            }
        }

        $backups = array_reverse($backups); // Mostrar más recientes primero

        return view('admin.backups.index', compact('backups'));
    }

    public function run()
    {
        // Esto corre el comando de backup
        Artisan::call('backup:run', ['--only-db' => true]);

        return redirect()->route('admin.backups.index')->with('success', 'Backup generado exitosamente.');
    }

    public function download($file_name)
    {
        $file = config('backup.backup.name') . '/' . $file_name;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists($file)) {
            return $disk->download($file);
        }

        return redirect()->route('admin.backups.index')->with('error', 'El archivo no existe.');
    }

    public function delete($file_name)
    {
        $file = config('backup.backup.name') . '/' . $file_name;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists($file)) {
            $disk->delete($file);
            return redirect()->route('admin.backups.index')->with('success', 'Backup eliminado exitosamente.');
        }

        return redirect()->route('admin.backups.index')->with('error', 'El archivo no existe.');
    }

    private function humanFilesize($size, $precision = 2)
    {
        $units = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }
}
