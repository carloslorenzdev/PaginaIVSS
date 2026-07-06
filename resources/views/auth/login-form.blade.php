<form class="space-y-6" action="{{ route('login') }}" method="POST">
    @csrf
    <div>
        <x-input.label for="usuario">Usuario</x-input.label>
        <x-input type="text" id="usuario" name="usuario" placeholder="Tu usuario" required error />
    </div>
    <div>
        <div class="flex justify-between items-center mb-1">
            <x-input.label for="password" class="!mb-0">Contraseña</x-input.label>
            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500">¿Olvidaste tu contraseña?</a>
        </div>
        <x-input.password id="password" name="password" placeholder="Tu contraseña" required error />
    </div>
    <div>
        <x-input.button class="w-full">
            Ingresar
        </x-input.button>
    </div>
</form>
