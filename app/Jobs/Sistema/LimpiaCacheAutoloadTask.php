<?php

namespace App\Jobs\Sistema;

use App\Jobs\Middleware\SkipOldJob;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class LimpiaCacheAutoloadTask implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use Queueable;
    use SerializesModels;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 250;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds to wait before retrying the job.
     * TAMBIEN EXISTE UN METODO QUE SE PUEDE DEVOLVER UN ARRAY
     * @var int
     */
    public $backoff = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'procesando-limpieza-cache-sistema';
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new SkipOldJob];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('optimize:clear');
        Process::timeout(300)->run('composer dumpautoload');
        Log::channel('jobs')->info('Limpieza de cache y recarga de aplicación exitosa');
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::channel('jobs')->error("Error al limpiar cache y autoload: [{$this->job->uuid()}]", [
            'job' => self::class,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
