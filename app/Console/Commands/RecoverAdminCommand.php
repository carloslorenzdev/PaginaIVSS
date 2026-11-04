<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RecoverAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ivss:recover-admin {usuario? : Nombre de usuario a restablecer o crear} {--password= : Contraseña (si no se especifica, se generará una segura aleatoriamente)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recupera acceso de administrador de forma segura reseteando la clave o creando un usuario de emergencia.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usuario = $this->argument('usuario');
        if (empty($usuario)) {
            $usuario = $this->ask('Ingrese el nombre de usuario a recuperar/crear:');
        }

        if (empty($usuario)) {
            $this->error('Debe indicar un nombre de usuario válido.');
            return 1;
        }

        $isGenerated = false;
        $password = $this->option('password');
        if (empty($password)) {
            $password = \Illuminate\Support\Str::password(16, true, true, false);
            $isGenerated = true;
        }

        $user = User::where('usuario', $usuario)->first();

        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
            $this->info("La contraseña del usuario '{$usuario}' ha sido restablecida exitosamente.");
        } else {
            $user = User::create([
                'usuario' => $usuario,
                'password' => Hash::make($password),
                'nombres' => 'Admin',
                'apellidos' => 'Emergencia',
                'cedula' => '00000000',
                'nacionalidad' => 'V',
                'activo' => true
            ]);
            $this->info("Usuario de emergencia '{$usuario}' creado exitosamente.");
        }

        if ($isGenerated) {
            $this->warn("Contraseña generada aleatoriamente: {$password}");
            $this->line("Guarde esta credencial de forma segura. No se volverá a mostrar.");
        }

        // Asignar rol de admin si existe
        if (Role::where('name', 'admin')->exists()) {
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
                $this->info("Rol 'admin' asignado correctamente.");
            }
        } else {
            $this->warn("El rol 'admin' no existe en el sistema.");
        }

        // Registro de auditoría
        if (function_exists('activity')) {
            activity('seguridad')
                ->causedByAnonymous()
                ->performedOn($user)
                ->log("Ejecución de comando artisan ivss:recover-admin para el usuario '{$usuario}'");
        }

        return 0;
    }
}
