<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageOptimizerService;
use App\Models\Banner;
use App\Models\Carrusel;
use App\Models\Medio;
use App\Models\Configuracion;
use App\Models\Boletin;
use App\Models\Revista;

class OptimizarImagenesWebpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ivss:optimizar-imagenes-webp
                            {--dry-run : Muestra los archivos a optimizar sin modificar la base de datos ni los archivos}
                            {--keep-originals : Conserva las imágenes originales sin eliminarlas del disco}
                            {--estaticos : Optimiza también los recursos estáticos pesados en public/img y public/imagenes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convierte todas las imágenes existentes (banners, carrusel, noticias, fondos de módulos y estáticos) a formato WebP optimizado';

    protected int $procesados = 0;
    protected int $errores = 0;
    protected int $bytesOriginales = 0;
    protected int $bytesOptimizados = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $keepOriginals = $this->option('keep-originals');
        $incluirEstaticos = $this->option('estaticos') || true; // Por defecto siempre optimizar estáticos pesados

        $this->info("===================================================================");
        $this->info("  IVSS - OPTIMIZACIÓN AUTOMÁTICA DE IMÁGENES A WEBP (ALTO RENDIMIENTO)  ");
        $this->info("===================================================================");

        if ($dryRun) {
            $this->warn("MODO SIMULACIÓN (--dry-run): No se realizarán cambios en BD ni en archivos.\n");
        }

        if (!function_exists('imagewebp')) {
            $this->error("ERROR: La extensión PHP GD no tiene soporte para WebP en este servidor.");
            return 1;
        }

        // 1. Banners y Alertas Emergentes
        $this->info("\n[1/6] Optimizando Banners y Promociones...");
        $this->optimizarBanners($dryRun, $keepOriginals);

        // 2. Carrusel Principal
        $this->info("\n[2/6] Optimizando Carrusel Principal...");
        $this->optimizarCarrusel($dryRun, $keepOriginals);

        // 3. Fondos de Módulos y Membrete (Configuraciones)
        $this->info("\n[3/6] Optimizando Fondos de Módulos y Membrete Oficial...");
        $this->optimizarConfiguraciones($dryRun, $keepOriginals);

        // 4. Medios (Noticias y Actividades Anuales)
        $this->info("\n[4/6] Optimizando Fotografías de Noticias y Galerías (Medios)...");
        $this->optimizarMedios($dryRun, $keepOriginals);

        // 5. Portadas de Boletines y Revistas
        $this->info("\n[5/6] Optimizando Portadas de Boletines y Revistas...");
        $this->optimizarPublicaciones($dryRun, $keepOriginals);

        // 6. Archivos Estáticos en public/
        if ($incluirEstaticos) {
            $this->info("\n[6/6] Optimizando Recursos Estáticos en public/ (Cintillo, Fondos, Banners base)...");
            $this->optimizarEstaticos($dryRun);
        }

        // Resumen Final
        $ahorroBytes = max(0, $this->bytesOriginales - $this->bytesOptimizados);
        $porcentaje = $this->bytesOriginales > 0 ? round(($ahorroBytes / $this->bytesOriginales) * 100, 1) : 0;

        $this->info("\n===================================================================");
        $this->info("RESUMEN DE OPTIMIZACIÓN WEBP");
        $this->info("===================================================================");
        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Archivos procesados', $this->procesados],
                ['Errores o no encontrados', $this->errores],
                ['Peso original total', round($this->bytesOriginales / 1024 / 1024, 2) . ' MB (' . number_format($this->bytesOriginales) . ' bytes)'],
                ['Peso final optimizado', round($this->bytesOptimizados / 1024 / 1024, 2) . ' MB (' . number_format($this->bytesOptimizados) . ' bytes)'],
                ['Ahorro total de transferencia', round($ahorroBytes / 1024 / 1024, 2) . ' MB (' . $porcentaje . '%)'],
            ]
        );

        if ($dryRun) {
            $this->info("Simulación finalizada. Ejecuta 'php artisan ivss:optimizar-imagenes-webp' sin --dry-run para aplicar los cambios.");
        } else {
            $this->info("¡Optimización completada con éxito! La página web ahora cargará considerablemente más rápido.");
        }

        return 0;
    }

    protected function optimizarBanners(bool $dryRun, bool $keepOriginals): void
    {
        $banners = Banner::whereNotNull('ruta_imagen')->get();

        foreach ($banners as $banner) {
            $ruta = $banner->ruta_imagen;
            if (!$ruta || str_ends_with(strtolower($ruta), '.webp')) {
                continue;
            }

            if (!Storage::disk('public')->exists($ruta)) {
                $this->warn("  - Banner ID {$banner->id}: Archivo {$ruta} no existe en storage.");
                $this->errores++;
                continue;
            }

            $sizeOrig = Storage::disk('public')->size($ruta);
            $this->bytesOriginales += $sizeOrig;

            if ($dryRun) {
                $this->line("  [SIMULACIÓN] Banner ID {$banner->id} ({$ruta}) -> WebP (~85% ahorro)");
                $this->bytesOptimizados += (int)($sizeOrig * 0.15);
                $this->procesados++;
                continue;
            }

            $nuevaRuta = ImageOptimizerService::convertirArchivoExistenteAWebp(
                $ruta,
                ImageOptimizerService::MAX_WIDTH_BANNER,
                ImageOptimizerService::CALIDAD_WEBP,
                'public',
                !$keepOriginals
            );

            if ($nuevaRuta) {
                $sizeWebp = Storage::disk('public')->size($nuevaRuta);
                $this->bytesOptimizados += $sizeWebp;
                $banner->update(['ruta_imagen' => $nuevaRuta]);
                $this->procesados++;
                $this->line("  ✓ Banner ID {$banner->id}: " . round($sizeOrig / 1024, 1) . " KB -> " . round($sizeWebp / 1024, 1) . " KB");
            } else {
                $this->bytesOptimizados += $sizeOrig;
                $this->errores++;
            }
        }
    }

    protected function optimizarCarrusel(bool $dryRun, bool $keepOriginals): void
    {
        $carruseles = Carrusel::whereNotNull('imagen_ruta')->get();

        foreach ($carruseles as $item) {
            $ruta = $item->imagen_ruta;
            if (!$ruta || str_ends_with(strtolower($ruta), '.webp')) {
                continue;
            }

            if (!Storage::disk('public')->exists($ruta)) {
                $this->warn("  - Carrusel ID {$item->id}: Archivo {$ruta} no existe.");
                $this->errores++;
                continue;
            }

            $sizeOrig = Storage::disk('public')->size($ruta);
            $this->bytesOriginales += $sizeOrig;

            if ($dryRun) {
                $this->line("  [SIMULACIÓN] Carrusel ID {$item->id} ({$ruta}) -> WebP");
                $this->bytesOptimizados += (int)($sizeOrig * 0.15);
                $this->procesados++;
                continue;
            }

            $nuevaRuta = ImageOptimizerService::convertirArchivoExistenteAWebp(
                $ruta,
                ImageOptimizerService::MAX_WIDTH_BANNER,
                ImageOptimizerService::CALIDAD_WEBP,
                'public',
                !$keepOriginals
            );

            if ($nuevaRuta) {
                $sizeWebp = Storage::disk('public')->size($nuevaRuta);
                $this->bytesOptimizados += $sizeWebp;
                $item->update(['imagen_ruta' => $nuevaRuta]);
                $this->procesados++;
                $this->line("  ✓ Carrusel ID {$item->id}: " . round($sizeOrig / 1024, 1) . " KB -> " . round($sizeWebp / 1024, 1) . " KB");
            } else {
                $this->bytesOptimizados += $sizeOrig;
                $this->errores++;
            }
        }
    }

    protected function optimizarConfiguraciones(bool $dryRun, bool $keepOriginals): void
    {
        $claves = [
            'alerta_emergente_img',
            'membrete_img',
            'bg_consultas',
            'bg_tiuna',
            'bg_farmacias',
            'bg_centros_salud',
            'bg_oficinas',
            'bg_servicios_funcionario',
        ];

        $configs = Configuracion::whereIn('clave', $claves)->whereNotNull('valor')->get();

        foreach ($configs as $config) {
            $ruta = $config->valor;
            if (!$ruta || str_ends_with(strtolower($ruta), '.webp')) {
                continue;
            }

            if (!Storage::disk('public')->exists($ruta)) {
                continue;
            }

            $sizeOrig = Storage::disk('public')->size($ruta);
            $this->bytesOriginales += $sizeOrig;

            if ($dryRun) {
                $this->line("  [SIMULACIÓN] Config {$config->clave} ({$ruta}) -> WebP");
                $this->bytesOptimizados += (int)($sizeOrig * 0.15);
                $this->procesados++;
                continue;
            }

            $nuevaRuta = ImageOptimizerService::convertirArchivoExistenteAWebp(
                $ruta,
                ImageOptimizerService::MAX_WIDTH_BANNER,
                ImageOptimizerService::CALIDAD_WEBP,
                'public',
                !$keepOriginals
            );

            if ($nuevaRuta) {
                $sizeWebp = Storage::disk('public')->size($nuevaRuta);
                $this->bytesOptimizados += $sizeWebp;
                $config->update(['valor' => $nuevaRuta]);
                $this->procesados++;
                $this->line("  ✓ {$config->clave}: " . round($sizeOrig / 1024, 1) . " KB -> " . round($sizeWebp / 1024, 1) . " KB");
            } else {
                $this->bytesOptimizados += $sizeOrig;
                $this->errores++;
            }
        }
    }

    protected function optimizarMedios(bool $dryRun, bool $keepOriginals): void
    {
        $medios = Medio::where('tipo', 'imagen')
            ->whereNotNull('ruta')
            ->get();

        foreach ($medios as $medio) {
            $ruta = $medio->ruta;
            if (!$ruta || str_ends_with(strtolower($ruta), '.webp')) {
                continue;
            }

            if (!Storage::disk('public')->exists($ruta)) {
                $this->errores++;
                continue;
            }

            $sizeOrig = Storage::disk('public')->size($ruta);
            $this->bytesOriginales += $sizeOrig;

            if ($dryRun) {
                $this->line("  [SIMULACIÓN] Medio ID {$medio->id} ({$medio->nombre_archivo}) -> WebP");
                $this->bytesOptimizados += (int)($sizeOrig * 0.15);
                $this->procesados++;
                continue;
            }

            $nuevaRuta = ImageOptimizerService::convertirArchivoExistenteAWebp(
                $ruta,
                ImageOptimizerService::MAX_WIDTH_NOTICIA,
                ImageOptimizerService::CALIDAD_WEBP,
                'public',
                !$keepOriginals
            );

            if ($nuevaRuta) {
                $sizeWebp = Storage::disk('public')->size($nuevaRuta);
                $this->bytesOptimizados += $sizeWebp;
                $medio->update([
                    'ruta' => $nuevaRuta,
                    'nombre_archivo' => basename($nuevaRuta),
                    'mime_type' => 'image/webp',
                    'tamano' => $sizeWebp,
                ]);
                $this->procesados++;
                $this->line("  ✓ Medio ID {$medio->id}: " . round($sizeOrig / 1024, 1) . " KB -> " . round($sizeWebp / 1024, 1) . " KB");
            } else {
                $this->bytesOptimizados += $sizeOrig;
                $this->errores++;
            }
        }
    }

    protected function optimizarPublicaciones(bool $dryRun, bool $keepOriginals): void
    {
        // Boletines
        $boletines = Boletin::whereNotNull('imagen_preview')->get();
        foreach ($boletines as $b) {
            $ruta = $b->imagen_preview;
            if (!$ruta || str_ends_with(strtolower($ruta), '.webp')) continue;
            if (!Storage::disk('public')->exists($ruta)) continue;

            $sizeOrig = Storage::disk('public')->size($ruta);
            $this->bytesOriginales += $sizeOrig;

            if ($dryRun) {
                $this->bytesOptimizados += (int)($sizeOrig * 0.15);
                $this->procesados++;
                continue;
            }

            $nuevaRuta = ImageOptimizerService::convertirArchivoExistenteAWebp(
                $ruta,
                1000,
                ImageOptimizerService::CALIDAD_WEBP,
                'public',
                !$keepOriginals
            );

            if ($nuevaRuta) {
                $sizeWebp = Storage::disk('public')->size($nuevaRuta);
                $this->bytesOptimizados += $sizeWebp;
                $b->update(['imagen_preview' => $nuevaRuta]);
                $this->procesados++;
                $this->line("  ✓ Boletín ID {$b->id}: Portada optimizada a WebP (" . round($sizeWebp / 1024, 1) . " KB)");
            }
        }

        // Revistas
        $revistas = Revista::whereNotNull('imagen_preview')->get();
        foreach ($revistas as $r) {
            $ruta = $r->imagen_preview;
            if (!$ruta || str_ends_with(strtolower($ruta), '.webp')) continue;
            if (!Storage::disk('public')->exists($ruta)) continue;

            $sizeOrig = Storage::disk('public')->size($ruta);
            $this->bytesOriginales += $sizeOrig;

            if ($dryRun) {
                $this->bytesOptimizados += (int)($sizeOrig * 0.15);
                $this->procesados++;
                continue;
            }

            $nuevaRuta = ImageOptimizerService::convertirArchivoExistenteAWebp(
                $ruta,
                1000,
                ImageOptimizerService::CALIDAD_WEBP,
                'public',
                !$keepOriginals
            );

            if ($nuevaRuta) {
                $sizeWebp = Storage::disk('public')->size($nuevaRuta);
                $this->bytesOptimizados += $sizeWebp;
                $r->update(['imagen_preview' => $nuevaRuta]);
                $this->procesados++;
                $this->line("  ✓ Revista ID {$r->id}: Portada optimizada a WebP (" . round($sizeWebp / 1024, 1) . " KB)");
            }
        }
    }

    protected function optimizarEstaticos(bool $dryRun): void
    {
        $archivosEstaticos = [
            public_path('imagenes/cintillo ivss_2026.png'),
            public_path('imagenes/fondo-ivss.png'),
            public_path('img/30-9-24-CABEZAL-PIEZA-texto-logos-blancos-1363x169px-sin-redes-1.png'),
            public_path('img/cropped-cropped-banner_1363x169-ai-brush-removebg-qne3b47g.png'),
            public_path('img/MINISTRA-MAGALLY1.jpg'),
            public_path('img/imagen.jpg'),
            public_path('img/image-3.jpg'),
            public_path('img/image-9.jpg'),
            public_path('img/marcha-2.jpg'),
            public_path('img/nota-2.jpg'),
            public_path('img/n.jpg'),
            public_path('img/image-7.jpg'),
            public_path('img/image-11.jpg'),
            public_path('img/image-10.jpg'),
            public_path('img/noticia1.jpg'),
        ];

        foreach ($archivosEstaticos as $rutaAbsoluta) {
            if (!file_exists($rutaAbsoluta)) continue;

            $sizeOrig = filesize($rutaAbsoluta);
            $this->bytesOriginales += $sizeOrig;

            $destinoWebp = pathinfo($rutaAbsoluta, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($rutaAbsoluta, PATHINFO_FILENAME) . '.webp';

            if ($dryRun) {
                $this->line("  [SIMULACIÓN] Estático: " . basename($rutaAbsoluta) . " (" . round($sizeOrig / 1024, 1) . " KB) -> WebP");
                $this->bytesOptimizados += (int)($sizeOrig * 0.15);
                $this->procesados++;
                continue;
            }

            $res = ImageOptimizerService::optimizarArchivoEstatico($rutaAbsoluta, $destinoWebp, 1920, ImageOptimizerService::CALIDAD_WEBP);

            if ($res && file_exists($res)) {
                $sizeWebp = filesize($res);
                $this->bytesOptimizados += $sizeWebp;
                $this->procesados++;
                $this->line("  ✓ Estático: " . basename($rutaAbsoluta) . " (" . round($sizeOrig / 1024, 1) . " KB -> " . round($sizeWebp / 1024, 1) . " KB)");
            } else {
                $this->bytesOptimizados += $sizeOrig;
                $this->errores++;
            }
        }
    }
}
