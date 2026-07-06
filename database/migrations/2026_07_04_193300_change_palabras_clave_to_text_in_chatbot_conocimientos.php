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
        Schema::table('chatbot_conocimientos', function (Blueprint $table) {
            $table->text('palabras_clave')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chatbot_conocimientos', function (Blueprint $table) {
            $table->string('palabras_clave', 255)->change();
        });
    }
};
