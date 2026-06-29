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
    protected $signature = 'ivss:recover-admin {usuario?} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recupera acceso de administrador reseteando la clave o creando un usuario de emergencia.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usuario = $this->argument('usuario') ?? 'admin_recovery';
        $password = $this->option('password') ?? 'Admin1234*';

        $user = User::where('usuario', $usuario)->first();

        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
            $this->info("La contraseña del usuario '{$usuario}' ha sido reseteada a: {$password}");
        } else {
            $user = User::create([
                'usuario' => $usuario,
                'password' => Hash::make($password),
                'nombres' => 'Admin',
                'apellidos' => 'Recovery',
                'cedula' => '00000000',
                'nacionalidad' => 'V',
                'activo' => true
            ]);
            $this->info("Usuario de emergencia '{$usuario}' creado con clave: {$password}");
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
    }
}
