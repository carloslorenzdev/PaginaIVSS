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
        if (!Schema::hasTable('nparroquia')) {
            Schema::create('nparroquia', function (Blueprint $table) {
                $table->integer('idparroquia')->primary();
                $table->integer('idmunicipiofk')->index();
                $table->string('parroquia', 100)->nullable();
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
        Schema::dropIfExists('nparroquia');
    }
};
