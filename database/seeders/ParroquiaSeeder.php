<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ParroquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/geografia/parroquias.json');

        if (!File::exists($path)) {
            $this->command?->error("Archivo {$path} no encontrado.");
            return;
        }

        $parroquias = json_decode(File::get($path), true);

        if (empty($parroquias)) {
            $this->command?->warn("El archivo {$path} está vacío.");
            return;
        }

        foreach (array_chunk($parroquias, 200) as $chunk) {
            DB::table('nparroquia')->upsert(
                $chunk,
                ['idparroquia'],
                ['idmunicipiofk', 'parroquia', 'idupdatefk', 'updated_at']
            );
        }

        $this->command?->info('Parroquias sembradas exitosamente: ' . count($parroquias));
    }
}
