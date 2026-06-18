<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividad_anual_medios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_anual_id')->constrained('actividades_anuales')->onDelete('cascade');
            $table->foreignId('medio_id')->constrained('medios')->onDelete('cascade');
            $table->string('tipo_relacion')->default('principal'); // principal, galeria, adjunto
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividad_anual_medios');
    }
};
