<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos_institucionales', function (Blueprint $table) {
            $table->id();
            $table->string('seccion', 60)->index(); // 'marco_normativo', 'contrataciones_publicas', 'biblioteca_formas', etc.
            $table->string('categoria', 120)->index(); // 'Decretos', 'Leyes Orgánicas', 'Formas', etc.
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('archivo_path')->nullable(); // Ruta relativa en storage/app/public
            $table->string('archivo_nombre_original')->nullable();
            $table->string('formato', 20)->default('pdf'); // 'pdf', 'doc', 'docx', 'xls', 'xlsx', etc.
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true)->index();
            $table->unsignedInteger('descargas')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_institucionales');
    }
};

