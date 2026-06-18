<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RendimientoController extends Controller
{
    public function index()
    {
        $serverInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'os' => PHP_OS,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        ];

        // Database size (MySQL)
        $dbSize = 0;
        try {
            if (DB::connection()->getDriverName() === 'pgsql') {
                $result = DB::select("SELECT pg_database_size(current_database()) / 1024 / 1024 AS size");
            } else {
                $dbName = env('DB_DATABASE');
                $result = DB::select("SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = ?", [$dbName]);
            }
            if (!empty($result)) {
                $dbSize = round($result[0]->size, 2);
            }
        } catch (\Exception $e) {
            // Ignore if driver doesn't support it
        }

        // Cache size (approximate by checking storage/framework/cache)
        $cacheSize = 0;
        $cachePath = storage_path('framework/cache/data');
        if (File::exists($cachePath)) {
            $cacheSize = $this->getDirectorySize($cachePath);
            $cacheSize = round($cacheSize / 1024 / 1024, 2);
        }

        // Logs size
        $logsSize = 0;
        $logsPath = storage_path('logs');
        if (File::exists($logsPath)) {
            $logsSize = $this->getDirectorySize($logsPath);
            $logsSize = round($logsSize / 1024 / 1024, 2);
        }

        return view('admin.rendimiento', compact('serverInfo', 'dbSize', 'cacheSize', 'logsSize'));
    }

    public function optimizar(Request $request)
    {
        $type = $request->input('type', 'all');
        $output = '';

        try {
            switch ($type) {
                case 'cache':
                    Artisan::call('cache:clear');
                    $output = 'Caché de la aplicación limpiada exitosamente.';
                    break;
                case 'config':
                    Artisan::call('config:clear');
                    $output = 'Caché de configuración limpiada exitosamente.';
                    break;
                case 'views':
                    Artisan::call('view:clear');
                    $output = 'Caché de vistas limpiada exitosamente.';
                    break;
                case 'routes':
                    Artisan::call('route:clear');
                    $output = 'Caché de rutas limpiada exitosamente.';
                    break;
                case 'all':
                    Artisan::call('optimize:clear');
                    $output = 'Limpieza profunda (Optimización total) completada exitosamente.';
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Tipo de limpieza no válido.']);
            }

            return response()->json([
                'success' => true,
                'message' => $output
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al ejecutar limpieza: ' . $e->getMessage()
            ]);
        }
    }

    private function getDirectorySize($path)
    {
        $size = 0;
        foreach (File::allFiles($path) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
}
