<?php

use App\Models\SesionUsuario;
use App\Models\User;
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
        $sesionUsuario = new SesionUsuario();
        Schema::connection($sesionUsuario->getConnectionName())->create($sesionUsuario->getTable(), function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->json('ips');
            $table->ipAddress('ip_client');
            $table->json('ips_client');
            $table->text('user_agent');
            $table->timestamp('login');
            $table->timestamp('logout')->nullable();
            $table->string('id_sesion');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $user = new User();
            $table->foreign('created_by')->references($user->getKeyName())->on($user->getTable());
            $table->foreign('updated_by')->references($user->getKeyName())->on($user->getTable());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $sesionUsuario = new SesionUsuario();
        Schema::connection($sesionUsuario->getConnectionName())->dropIfExists($sesionUsuario->getTable());
    }
};
