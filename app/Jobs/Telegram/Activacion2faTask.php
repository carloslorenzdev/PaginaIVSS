<?php

namespace App\Jobs\Telegram;

use App\Jobs\Middleware\SkipOldJob;
use App\Services\Auth\TelegramService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Activacion2faTask implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use SerializesModels;
    use Queueable;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 8;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 9;

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
    public $backoff = 2;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('telegram_activacion');
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            Skip::when(!TelegramService::isEnabled()),
            new SkipOldJob
        ];
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'procesando-mensajes-recibidos-telegram';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        TelegramService::procesaMensajesActivacion2fa();
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::channel('jobs')->error("Error procesar mensajes de telegram: [{$this->job->uuid()}]", [
            'job' => self::class,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
