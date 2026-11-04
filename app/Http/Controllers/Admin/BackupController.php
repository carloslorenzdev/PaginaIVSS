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
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar backups.');
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
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar backups.');
        // Esto corre el comando de backup
        Artisan::call('backup:run', ['--only-db' => true]);

        return redirect()->route('admin.backups.index')->with('success', 'Backup generado exitosamente.');
    }

    public function download($file_name)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar backups.');

        // Mitigación Path Traversal (CWE-22): Sanitización y lista blanca estricta
        $safeFileName = basename($file_name);
        if (!preg_match('/^[a-zA-Z0-9_\-\.]+\.zip$/', $safeFileName)) {
            abort(400, 'Nombre de archivo de respaldo inválido.');
        }

        $file = config('backup.backup.name') . '/' . $safeFileName;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists($file)) {
            if (function_exists('activity')) {
                activity('backup')
                    ->causedBy(auth()->user())
                    ->log("Descarga de respaldo de base de datos: {$safeFileName}");
            }
            return $disk->download($file);
        }

        return redirect()->route('admin.backups.index')->with('error', 'El archivo no existe.');
    }

    public function delete($file_name)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar backups.');

        // Mitigación Path Traversal (CWE-22): Sanitización y lista blanca estricta
        $safeFileName = basename($file_name);
        if (!preg_match('/^[a-zA-Z0-9_\-\.]+\.zip$/', $safeFileName)) {
            abort(400, 'Nombre de archivo de respaldo inválido.');
        }

        $file = config('backup.backup.name') . '/' . $safeFileName;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists($file)) {
            $disk->delete($file);
            if (function_exists('activity')) {
                activity('backup')
                    ->causedBy(auth()->user())
                    ->log("Eliminación de respaldo de base de datos: {$safeFileName}");
            }
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
