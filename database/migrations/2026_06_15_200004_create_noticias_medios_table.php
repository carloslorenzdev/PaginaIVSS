<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias_medios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('noticia_id')->constrained('noticias')->cascadeOnDelete();
            $table->foreignId('medio_id')->constrained('medios')->cascadeOnDelete();
            $table->enum('tipo_relacion', ['principal', 'galeria', 'adjunto'])->default('galeria');
            $table->integer('orden')->default(0);
            $table->timestamp('fecha_asociacion')->useCurrent();
            $table->unique(['noticia_id', 'medio_id'], 'unique_noticia_medio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias_medios');
    }
};
