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
            $table->foreignId('noticia_id')->nullable()->constrained('noticias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrusels', function (Blueprint $table) {
            $table->dropForeign(['noticia_id']);
            $table->dropColumn('noticia_id');
        });
    }
};
