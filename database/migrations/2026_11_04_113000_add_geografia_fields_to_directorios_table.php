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
        Schema::table('directorios', function (Blueprint $table) {
            if (!Schema::hasColumn('directorios', 'municipio')) {
                $table->string('municipio')->nullable()->after('estado');
            }
            if (!Schema::hasColumn('directorios', 'parroquia')) {
                $table->string('parroquia')->nullable()->after('municipio');
            }
            if (!Schema::hasColumn('directorios', 'id_estado')) {
                $table->integer('id_estado')->nullable()->after('parroquia');
            }
            if (!Schema::hasColumn('directorios', 'id_municipio')) {
                $table->integer('id_municipio')->nullable()->after('id_estado');
            }
            if (!Schema::hasColumn('directorios', 'id_parroquia')) {
                $table->integer('id_parroquia')->nullable()->after('id_municipio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('directorios', function (Blueprint $table) {
            $table->dropColumn([
                'municipio',
                'parroquia',
                'id_estado',
                'id_municipio',
                'id_parroquia',
            ]);
        });
    }
};

