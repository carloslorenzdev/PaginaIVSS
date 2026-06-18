<?php

return [
    /*
     * Enable / disable Google2FA.
     */
    'enabled' => env('OTP_GOOGLE2FA_ENABLED', true),

    /*
     * Lifetime in minutes.
     *
     * In case you need your users to be asked for a new one time passwords from time to time.
     */
    'lifetime' => env('OTP_GOOGLE2FA_LIFETIME', 0), // 0 = eternal

    /*
     * Renew lifetime at every new request.
     */
    'keep_alive' => env('OTP_GOOGLE2FA_KEEP_ALIVE', false),

    /*
     * Auth container binding.
     */
    'auth' => 'auth',

    /*
     * Guard.
     */
    'guard' => '',

    /*
     * 2FA verified session var.
     */
    'session_var' => 'auth.two_factor_confirmed_at',

    /*
     * One Time Password request input name.
     */
    'otp_input' => 'otp',

    /*
     * One Time Password Window.
     */
    'window' => 1,

    /*
     * Forbid user to reuse One Time Passwords.
     */
    'forbid_old_passwords' => true,

    /*
     * User's table column for google2fa secret.
     */
    'otp_secret_column' => 'two_factor_secret',

    /*
     * User's table column for confirmation the google2fa secret.
     */
    'otp_secret_confirmed_at' => 'two_factor_confirmed_at',

    /*
     * One Time Password View.
     */
    'view' => 'auth.authenticator-app.configuracion',

    /*
     * One Time Password error message.
     */
    'error_messages' => [
        // 'wrong_otp'       => "The 'One Time Password' typed was wrong.",
        // 'cannot_be_empty' => 'One Time Password cannot be empty.',
        // 'unknown'         => 'An unknown error has occurred. Please try again.',
        'wrong_otp'       => "Código incorrecto.",
        'cannot_be_empty' => 'Código es obligatorio',
        'unknown'         => 'Ha ocurrido un error. Intenta de nuevo.',
    ],

    /*
     * Throw exceptions or just fire events?
     */
    'throw_exceptions' => env('OTP_GOOGLE2FA_THROW_EXCEPTION', true),

    /*
     * Which image backend to use for generating QR codes?
     *
     * Supports imagemagick, svg and eps
     */
    'qrcode_image_backend' => \PragmaRX\Google2FALaravel\Support\Constants::QRCODE_IMAGE_BACKEND_SVG,
];
