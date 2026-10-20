<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeografiaSeeder extends Seeder
{
    /**
     * Run the database seeds in order.
     */
    public function run(): void
    {
        $this->call([
            PaisSeeder::class,
            EstadoSeeder::class,
            MunicipioSeeder::class,
            ParroquiaSeeder::class,
        ]);
    }
}
