<?php

namespace App\Jobs\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class SkipOldJob
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        $payload = $job->job->payload();
        if (array_key_exists('createdAt', $payload)) {
            $timeout = array_key_exists('timeout', $payload) ? $payload['timeout'] : 3600;
            // Calcula la diferencia en segundos desde que se creó el job
            if (now()->parse($payload['createdAt'], 'America/Caracas')->diffInSeconds() > $timeout) {
                // No ejecuta el job
                Log::channel('jobs')->warning(
                    'Saltando JOB: ' . $job::class . ' por fuera de tiempo',
                    [
                        'job' => $job::class,
                        'created_at' => now()->parse($payload['createdAt'])->isoFormat('D MMM Y, h:mm:s a'),
                        'timeout' => $timeout,
                        'diferencia' => now()->parse($payload['createdAt'], 'America/Caracas')
                            ->longRelativeToNowDiffForHumans(now(), 5),
                    ]
                );
                return;
            }
        }
        // Ejecuta el job
        $next($job);
    }
}
