<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/geografia/municipios.json');

        if (!File::exists($path)) {
            $this->command?->error("Archivo {$path} no encontrado.");
            return;
        }

        $municipios = json_decode(File::get($path), true);

        if (empty($municipios)) {
            $this->command?->warn("El archivo {$path} está vacío.");
            return;
        }

        foreach (array_chunk($municipios, 100) as $chunk) {
            DB::table('nmunicipio')->upsert(
                $chunk,
                ['idmunicipio'],
                ['idestadofk', 'municipio', 'idupdatefk', 'updated_at']
            );
        }

        $this->command?->info('Municipios sembrados exitosamente: ' . count($municipios));
    }
}
