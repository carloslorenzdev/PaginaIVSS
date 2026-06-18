<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medios', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['imagen', 'video', 'documento']);
            $table->string('nombre_original', 255);
            $table->string('nombre_archivo', 255);
            $table->string('ruta', 500);
            $table->string('mime_type', 100)->nullable();
            $table->integer('tamano')->nullable();
            $table->integer('ancho')->nullable();
            $table->integer('alto')->nullable();
            $table->integer('duracion')->nullable();
            $table->text('leyenda')->nullable();
            $table->string('credito', 255)->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('fecha_subida')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medios');
    }
};
