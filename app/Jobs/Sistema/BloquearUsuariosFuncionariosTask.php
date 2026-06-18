<?php

namespace App\Jobs\Sistema;

use App\Jobs\Middleware\SkipOldJob;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BloquearUsuariosFuncionariosTask implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use Queueable;
    use SerializesModels;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 1750;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 1800;

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
     * Tiempo en dias para bloqueo de usuarios inactivos
     * @var int
     */
    public $diasInactivo = 0;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->diasInactivo = intval(config('services.sistema.usuarios.dias_inactividad', 0));
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'bloqueo-usuarios-funcionarios-sistema';
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
        $mensaje = 'Bloqueo de usuario funcionario inactivo no se ejecutó. Variable configurada a 0';
        if ($this->diasInactivo) {
            $cantidad = 0;
            User::with('ultimoAcceso')->role('Funcionario')->activo()->chunkById(20, function (Collection $users) use (&$cantidad) {
                foreach ($users as $usuario) {
                    $bloquear = false;
                    $observacion = '[BLOQUEO AUTOMÁTICO] Usuario bloqueado por inactividad de ';
                    $observacion .= intval($usuario->ultimoAcceso->created_at->diffInDays());
                    if ($usuario->ultimoAcceso) {
                        // SE VALIDA FECHA ULTIMO INGRESO
                        if ($usuario->ultimoAcceso->created_at->diffInDays() > $this->diasInactivo) {
                            $bloquear = true;
                            $observacion .= ' días. El último ingreso al sistema fue el ';
                            $observacion .= $usuario->ultimoAcceso->formatoISO('created_at');
                        }
                    } else {
                        // NO HA INICIADO SESIÓN, SE APLICA A FECHA DE CREACIÓN
                        if ($usuario->created_at->diffInDays() > $this->diasInactivo) {
                            $bloquear = true;
                            $observacion .= ' días. El usuario no ha tenido el primer ingreso al sistema desde su fecha de registro el ';
                            $observacion .= $usuario->formatoISO('created_at');
                        }
                    }
                    if ($bloquear) {
                        $cantidad += 1;
                        DB::transaction(function () use ($usuario, $observacion) {
                            $usuario->bloqueado = now();
                            $usuario->updated_by = 1;
                            $usuario->save();

                            $usuario->observaciones()->create([
                                'observacion' => $observacion,
                                'created_by' => 1,
                            ]);
                        });
                    }
                }
            });
            $cantidad = number_format($cantidad, 0, ',', '.');
            $mensaje = 'Bloqueados ' . $cantidad . ' usuarios funcionarios por inactividad mayor a ' . $this->diasInactivo . ' días';
        }
        Log::channel('jobs')->info($mensaje, ['job' => self::class, 'dias' => $this->diasInactivo]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::channel('jobs')->error("Error al bloquear usuarios funcionarios inactivos: [{$this->job->uuid()}]", [
            'job' => self::class,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
