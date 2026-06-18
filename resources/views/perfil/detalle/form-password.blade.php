<div class="p-5">
    <x-card.title>
        <i class="bx bx-key bx-flip-horizontal"></i>
        Contraseña
    </x-card.title>
    <x-card.subtitle>
        Actualiza tu contraseña. Asegura que tenga mínimo 8 caracteres.
    </x-card.subtitle>
    <form class="space-y-6 mt-5" data-hs-toggle-password-group="" action="{{ route('perfil.actualiza-pass') }}"
        method="POST">
        @method('PUT')
        @csrf
        <div>
            <x-input.label for="current_password">Contraseña Actual</x-input.label>
            <x-input.password id="current_password" name="current_password" placeholder="Tu actual contraseña"
                toggleTarget='["#current_password","#password","#password_confirmation"]' required />
            <x-input.error campo="current_password" bag="updatePassword" />
        </div>
        <div>
            <x-input.label for="password">Nueva Contraseña</x-input.label>
            <x-input.password id="password" name="password" placeholder="Tu nueva contraseña"
                toggleTarget='["#current_password","#password","#password_confirmation"]' required />
            <x-input.error campo="password" bag="updatePassword" />
        </div>
        <div>
            <x-input.label for="password_confirmation">
                Confirmación Contraseña
            </x-input.label>
            <x-input.password id="password_confirmation" name="password_confirmation"
                placeholder="Confirma la nueva contraseña"
                toggleTarget='["#current_password","#password","#password_confirmation"]' required />
            <x-input.error campo="password_confirmation" bag="updatePassword" />
        </div>
        <div>
            <x-input.button>
                Cambiar
            </x-input.button>
        </div>
    </form>
</div>
