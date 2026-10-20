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
        if (!Schema::hasTable('nmunicipio')) {
            Schema::create('nmunicipio', function (Blueprint $table) {
                $table->integer('idmunicipio')->primary();
                $table->integer('idestadofk');
                $table->string('municipio', 100);
                $table->integer('idupdatefk')->nullable();
                $table->timestamp('updated_at')->nullable()->useCurrent();

                $table->foreign('idestadofk', 'nmunicipio_nestado_fk')
                      ->references('idestado')
                      ->on('nestado')
                      ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nmunicipio');
    }
};
