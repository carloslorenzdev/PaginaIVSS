<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/geografia/estados.json');

        if (!File::exists($path)) {
            $this->command?->error("Archivo {$path} no encontrado.");
            return;
        }

        $estados = json_decode(File::get($path), true);

        if (empty($estados)) {
            $this->command?->warn("El archivo {$path} está vacío.");
            return;
        }

        foreach (array_chunk($estados, 100) as $chunk) {
            DB::table('nestado')->upsert(
                $chunk,
                ['idestado'],
                ['idpaisfk', 'estado', 'nomenclatura', 'capital', 'idupdatefk', 'updated_at']
            );
        }

        $this->command?->info('Estados sembrados exitosamente: ' . count($estados));
    }
}
