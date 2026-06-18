<?php

use App\Models\User;
use App\Models\UserSession;
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
        $users = new User();
        Schema::connection($users->getConnectionName())->create($users->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->unique();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('cambio_pass')->nullable();
            $table->timestamp('bloqueado')->nullable();
            $table->text('avatar')->nullable();
            $table->rememberToken();
            $table->text('two_factor_secret')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->text('id_telegram')->nullable();
            $table->timestamp('telegram_confirmed_at')->nullable();
            $table->string('fk_oficina_ivss')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection($users->getConnectionName())->create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        $sessions = new UserSession();
        Schema::connection($sessions->getConnectionName())->create($sessions->getTable(), function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $users = new User();
        Schema::connection($users->getConnectionName())->dropIfExists($users->getTable());
        Schema::connection($users->getConnectionName())->dropIfExists('password_reset_tokens');
        $sessions = new UserSession();
        Schema::connection($sessions->getConnectionName())->dropIfExists($sessions->getTable());
    }
};
