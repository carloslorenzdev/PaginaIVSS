<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/geografia/paises.json');

        if (!File::exists($path)) {
            $this->command?->error("Archivo {$path} no encontrado.");
            return;
        }

        $paises = json_decode(File::get($path), true);

        if (empty($paises)) {
            $this->command?->warn("El archivo {$path} está vacío.");
            return;
        }

        foreach (array_chunk($paises, 100) as $chunk) {
            DB::table('npais')->upsert(
                $chunk,
                ['idpais'],
                ['pais', 'capital', 'idcontinentefk', 'idupdatefk', 'updated_at']
            );
        }

        $this->command?->info('Países sembrados exitosamente: ' . count($paises));
    }
}
