<?php

namespace App\Enums;

enum TwoFactorAuthenticatorEnum: string
{
    case AUTHENTICATOR = 'authenticator';
    case TELEGRAM = 'telegram';
    case CORREO_ELECTRONICO = 'correo';
}
