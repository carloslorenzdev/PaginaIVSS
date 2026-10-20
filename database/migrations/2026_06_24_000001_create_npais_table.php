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
        if (!Schema::hasTable('npais')) {
            Schema::create('npais', function (Blueprint $table) {
                $table->integer('idpais')->primary();
                $table->string('pais', 100);
                $table->string('capital', 100);
                $table->integer('idcontinentefk');
                $table->integer('idupdatefk')->nullable();
                $table->timestamp('updated_at')->nullable()->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npais');
    }
};
