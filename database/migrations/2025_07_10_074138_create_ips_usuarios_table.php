<?php

use App\Models\IpUsuario;
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
        $ipUsuario = new IpUsuario();
        Schema::connection($ipUsuario->getConnectionName())->create($ipUsuario->getTable(), function (Blueprint $table) {
            $table->unsignedBigInteger('fk_usuario');
            $table->ipAddress('ip');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['fk_usuario', 'ip'], 'fk_usuario_ip_index');
            $table->unique(['fk_usuario', 'ip'], 'fk_usuario_ip_unique');

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
        $ipUsuario = new IpUsuario();
        Schema::connection($ipUsuario->getConnectionName())->dropIfExists($ipUsuario->getTable());
    }
};
