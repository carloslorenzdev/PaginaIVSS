<div @class([
    'flex items-center',
    'justify-between' => $user->hasEnabled2fa(),
])>
    <div>
        <x-card.title>
            <i class="bx bx-shield"></i>
            Autenticación de Dos Factores (2FA)
        </x-card.title>
        <x-card.subtitle>
            Lista de métodos de autenticación activos
        </x-card.subtitle>
    </div>
    @if ($user->hasEnabled2fa())
        <x-button.link href="{{ route('usuarios.desactivar-2fa', $user) }}"
            class="!gap-x-0.5 !py-1 text-red-600 hover:text-red-800 focus:text-red-600 dark:text-neutral-500 dark:hover:text-red-500 dark:focus:text-red-500">
            Desactivar
            <i class="bx bx-chevron-right"></i>
        </x-button.link>
    @endif
</div>
<div class="grid grid-cols-2 gap-6 mt-5 px-10">
    <div>
        <x-card class="p-3 text-center space-y-2">
            <div class="flex justify-center items-center">
                <div class="p-3 rounded-lg bg-sky-100 text-sky-800 dark:bg-sky-800/30 dark:text-sky-500">
                    <i class="bx bxs-shield"></i>
                </div>
            </div>
            <p class="text-sm text-gray-800 dark:text-neutral-200 capitalize">Authenticator App</p>
            <x-badge color="{{ $user->google2faEnabled() ? 'teal' : 'yellow' }}">
                <i class="bx bx-{{ $user->google2faEnabled() ? 'check' : 'block' }}"></i>
                {{ $user->google2faEnabled() ? 'Habilitado' : 'Deshabilitado' }}
            </x-badge>
        </x-card>
    </div>
    <div>
        <x-card class="p-3 text-center space-y-2">
            <div class="flex justify-center items-center">
                <div class="p-3 rounded-lg bg-sky-100 text-sky-800 dark:bg-sky-800/30 dark:text-sky-500">
                    <i class="bx bxs-envelope"></i>
                </div>
            </div>
            <p class="text-sm text-gray-800 dark:text-neutral-200 capitalize">Correo</p>
            <x-badge color="gray">
                <i class="bx bx-x"></i>
                No disponible
            </x-badge>
        </x-card>
    </div>
    <div>
        <x-card class="p-3 text-center space-y-2">
            <div class="flex justify-center items-center">
                <div class="p-3 rounded-lg bg-sky-100 text-sky-800 dark:bg-sky-800/30 dark:text-sky-500">
                    <i class="bx bxl-telegram"></i>
                </div>
            </div>
            <p class="text-sm text-gray-800 dark:text-neutral-200 capitalize">Telegram App</p>
            <x-badge color="{{ $user->telegram2faEnabled() ? 'teal' : 'yellow' }}">
                <i class="bx bx-{{ $user->telegram2faEnabled() ? 'check' : 'block' }}"></i>
                {{ $user->telegram2faEnabled() ? 'Habilitado' : 'Deshabilitado' }}
            </x-badge>
        </x-card>
    </div>
</div>
