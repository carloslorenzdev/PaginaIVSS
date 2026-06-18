<form action="{{ route('usuarios.registrar') }}" method="POST">
    @csrf
    <div class="grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-5">
        <div>
            <x-input.label for="nombre" value="Nombre Completo" />
            <x-input type="text" id="nombre" name="nombre" placeholder="María Alejandra"
                value="{{ old('nombre') }}" required error />
        </div>
        <div>
            <x-input.label for="usuario" value="Usuario" />
            <x-input type="text" id="usuario" name="usuario" placeholder="malejandra"
                value="{{ old('usuario') }}" required error />
        </div>
        <div>
            <x-input.label for="email" value="Correo Electrónico" />
            <x-input type="email" id="email" name="email" placeholder="ejemplo@ivss.gob.ve"
                value="{{ old('email') }}" required error />
        </div>
        <div class="col-span-full">
            <x-input.label for="rol" value="Rol" />
            <div class="flex flex-col md:flex-row gap-2">
                @foreach ($roles as $rol)
                    <label for="rol-{{ $rol->name }}"
                        class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <input type="radio" name="rol"
                            class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                            id="rol-{{ $rol->name }}" value="{{ $rol->name }}" @checked($rol->name == old('rol'))>
                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">
                            {{ str()->of($rol->name)->title() }}
                        </span>
                    </label>
                @endforeach
            </div>
            <x-input.error campo="rol" />
        </div>
    </div>
    <div class="mt-6">
        <x-input.button>
            Registrar
        </x-input.button>
    </div>
</form>
