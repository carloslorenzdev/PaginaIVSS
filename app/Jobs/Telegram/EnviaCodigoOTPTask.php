<?php

namespace App\Jobs\Telegram;

use App\Jobs\Middleware\SkipOldJob;
use App\Models\User;
use App\Services\Auth\TelegramService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnviaCodigoOTPTask implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use Queueable;
    use SerializesModels;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 50;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

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
     * Usuario al que se le envía en codigo OTP
     * @var User
     */
    public $usuario;

    /**
     * Create a new job instance.
     */
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
        $this->onQueue('telegram_otp');
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
        return $this->usuario->id . '-envia-codigo-otp-telegram';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        TelegramService::enviaCodigoOtp($this->usuario);
        Log::channel('acciones')->info(
            'Enviado código OTP al usuario "' . $this->usuario->usuario . '" vía Telegram App.',
            [
                // 'job' => $this->job->getJobId(),// id tabla jobs 355
                'job_id' => $this->job->uuid(),
            ]
        );
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::channel('jobs')->error(
            "Error enviar código OTP al usuario {$this->usuario->usuario} vía Telegram App: [{$this->job->uuid()}]",
            [
                'job' => self::class,
                'usuario' => $this->usuario->usuario,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]
        );
    }
}
