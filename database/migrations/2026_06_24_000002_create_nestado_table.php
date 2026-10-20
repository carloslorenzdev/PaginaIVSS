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
        if (!Schema::hasTable('nestado')) {
            Schema::create('nestado', function (Blueprint $table) {
                $table->integer('idestado')->primary();
                $table->integer('idpaisfk');
                $table->string('estado', 100);
                $table->string('nomenclatura', 2)->nullable();
                $table->string('capital', 100)->nullable();
                $table->integer('idupdatefk')->nullable();
                $table->timestamp('updated_at')->nullable()->useCurrent();

                $table->foreign('idpaisfk', 'nestado_npais_fk')
                      ->references('idpais')
                      ->on('npais')
                      ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nestado');
    }
};
