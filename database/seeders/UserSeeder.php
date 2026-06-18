<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::whereUsuario('admin')->doesntexist()) {
            $admin = User::create([
                'usuario' => 'admin',
                'nombre' => 'Administrador',
                'email' => 'admin@prensa.com',
                'password' => Hash::make('admin123'),
                'cambio_pass' => now(),
                'created_by' => 1,
            ]);
            $admin->assignRole('admin');
        }

        if (User::whereUsuario('redactor')->doesntexist()) {
            $redactor = User::create([
                'usuario' => 'redactor',
                'nombre' => 'Redactor de Prensa',
                'email' => 'redactor@prensa.com',
                'password' => Hash::make('redactor123'),
                'cambio_pass' => now(),
                'created_by' => 1,
            ]);
            $redactor->assignRole('redactor');
        }

        if (User::whereUsuario('aprobador')->doesntexist()) {
            $aprobador = User::create([
                'usuario' => 'aprobador',
                'nombre' => 'Aprobador de Prensa',
                'email' => 'aprobador@prensa.com',
                'password' => Hash::make('aprobador123'),
                'cambio_pass' => now(),
                'created_by' => 1,
            ]);
            $aprobador->assignRole('aprobador');
        }
    }
}
