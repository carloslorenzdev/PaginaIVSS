<form class="space-y-6" action="{{ route('login') }}" method="POST">
    @csrf
    <div>
        <x-input.label for="usuario">Usuario</x-input.label>
        <x-input type="text" id="usuario" name="usuario" placeholder="Tu usuario" required error />
    </div>
    <div>
        <x-input.label for="password">Contraseña</x-input.label>
        <x-input.password id="password" name="password" placeholder="Tu contraseña" required error />
    </div>
    <div>
        <x-input.button class="w-full">
            Ingresar
        </x-input.button>
    </div>
</form>
