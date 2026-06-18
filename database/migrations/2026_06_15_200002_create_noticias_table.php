<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración consolidada para la tabla de noticias.
 * Incluye todos los campos añadidos en las migraciones posteriores de Prensa-main:
 *  - enlace_externo
 *  - etiquetas
 *  - creditos_autor
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->string('slug', 255)->unique();
            $table->longText('contenido')->nullable();
            $table->text('etiquetas')->nullable();
            $table->text('resumen')->nullable();
            $table->string('enlace_externo', 500)->nullable();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
            $table->foreignId('autor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('creditos_autor', 255)->nullable();
            $table->boolean('publicado')->default(false);
            $table->timestamp('fecha_publicacion')->nullable();
            $table->timestamps();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
