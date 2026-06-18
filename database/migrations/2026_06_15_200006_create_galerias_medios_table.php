<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galerias_medios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galeria_id')->constrained('galerias')->cascadeOnDelete();
            $table->foreignId('medio_id')->constrained('medios')->cascadeOnDelete();
            $table->integer('orden')->default(0);
            $table->timestamp('fecha_asociacion')->useCurrent();
            $table->unique(['galeria_id', 'medio_id'], 'unique_galeria_medio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galerias_medios');
    }
};
