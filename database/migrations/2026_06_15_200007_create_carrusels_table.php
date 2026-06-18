<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración consolidada del carrusel.
 * Combina todas las migraciones sucesivas de Prensa-main:
 *  - create_carrusels_table (original)
 *  - rename_titulo_to_enlace
 *  - add_detalles
 *  - change_fecha_publicacion_type
 *  - (campo autor no estaba en migraciones pero sí en modelo, se incluye)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrusels', function (Blueprint $table) {
            $table->id();
            $table->string('imagen_ruta');
            $table->string('enlace')->nullable();
            $table->string('titulo')->nullable();
            $table->text('detalles')->nullable();
            $table->string('autor')->nullable();
            $table->text('etiquetas')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrusels');
    }
};
