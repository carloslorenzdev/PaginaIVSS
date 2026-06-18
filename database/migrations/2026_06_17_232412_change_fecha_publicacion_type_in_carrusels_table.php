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
        Schema::table('carrusels', function (Blueprint $table) {
            $table->dateTime('fecha_publicacion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrusels', function (Blueprint $table) {
            $table->date('fecha_publicacion')->nullable()->change();
        });
    }
};
