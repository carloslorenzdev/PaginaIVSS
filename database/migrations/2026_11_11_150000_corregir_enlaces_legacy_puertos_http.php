<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Configuracion;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            // Corregir URLs que tengan https:// apuntando a puertos HTTP legacy (28080-28089 o 9090)
            $configs = Configuracion::where('valor', 'like', 'https://%:2808%')
                ->orWhere('valor', 'like', 'https://%:9090%')
                ->get();

            foreach ($configs as $config) {
                $config->valor = preg_replace('/^https:\/\//i', 'http://', $config->valor);
                $config->save();
            }
        } catch (\Throwable $e) {
            // Silenciar si la tabla aún no existe o en entornos de prueba
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No revertir porque los puertos 28080-28089 son exclusivamente HTTP y carecen de SSL
    }
};
