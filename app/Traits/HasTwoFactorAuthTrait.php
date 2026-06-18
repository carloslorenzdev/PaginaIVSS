<?php

namespace App\Traits;

use App\Enums\TwoFactorAuthenticatorEnum;

trait HasTwoFactorAuthTrait
{
    /**
     * Verifica si tiene algun método de 2FA
     */
    public function hasEnabled2fa(): bool
    {
        return $this->google2faEnabled() || $this->telegram2faEnabled() || $this->emailEnabled();
    }

    /**
     * Valida si tieene el método de Authenticator activo
     */
    public function google2faEnabled(): bool
    {
        return $this->two_factor_secret && $this->two_factor_confirmed_at;
    }

    /**
     * Valida si tieene el método de Telegram activo
     */
    public function telegram2faEnabled(): bool
    {
        return $this->id_telegram && $this->telegram_confirmed_at;
    }

    /**
     * Valida si tieene el método de Correo activo
     */
    public function emailEnabled(): bool
    {
        return $this->email && $this->email_verified_at;
    }

    /**
     * Debuelve los métodos activos de 2FA
     */
    public function twoFactorAuthEnabled(): null|array
    {
        if (!$this->hasEnabled2fa()) {
            return null;
        }

        $twoFactorAuth = [];

        if ($this->google2faEnabled()) {
            $twoFactorAuth[] = TwoFactorAuthenticatorEnum::AUTHENTICATOR->value;
        }

        if ($this->telegram2faEnabled()) {
            $twoFactorAuth[] = TwoFactorAuthenticatorEnum::TELEGRAM->value;
        }

        if ($this->emailEnabled()) {
            $twoFactorAuth[] = TwoFactorAuthenticatorEnum::CORREO_ELECTRONICO->value;
        }

        return $twoFactorAuth;
    }
}
