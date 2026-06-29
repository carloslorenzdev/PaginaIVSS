@forelse ($usuarios as $user)
    <x-card class="relative p-5 hover:bg-gray-100/50 dark:hover:bg-neutral-700/50 text-gray-800 dark:text-neutral-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <div class="col-span-full lg:col-span-2">
                <div class="flex flex-col items-start sm:flex-row sm:items-center gap-3">
                    <x-avatar.item class="font-semibold" size="size-10" descripcion="{{ $user->iniciales }}" />
                    <a href="{{ route('usuarios.detalle', $user) }}" class="hover:underline truncate">
                        <p class="block font-medium truncate">
                            {{ $user->usuario }}
                        </p>
                        <small class="block font-medium truncate text-gray-500 dark:text-neutral-500">
                            {{ $user->nombre }}
                        </small>
                    </a>
                    <x-badge color="{{ $user->colorEstatus() }}">
                        <i class="bx bx-{{ $user->isActivo() ? 'check' : 'block' }}"></i>
                        {{ $user->estatus() }}
                    </x-badge>
                </div>
            </div>
            <div class="md:col-span-1 lg:col-span-2 xl:col-span-1">
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">Roles</p>
                <div class="flex gap-x-3 mb-2">
                    <p class="text-sm">{{ $user->getRoleNames()->join(', ', ' y ') ?: '-' }}</p>
                </div>
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">Última Conexión</p>
                <p class="text-sm">
                    @if($user->ultimoAcceso)
                        {{ $user->ultimoAcceso->ip }} <br>
                        <span class="text-xs text-gray-400">{{ $user->ultimoAcceso->login->diffForHumans() }}</span>
                    @else
                        -
                    @endif
                </p>
            </div>
            <div class="md:col-span-1 lg:col-span-2 xl:col-span-1">
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">F. Registro</p>
                <p>{{ $user->formatoISO('created_at') }}</p>
            </div>
            <div class="col-span-full md:col-span-1 lg:col-span-2 xl:col-span-1 place-self-end lg:place-self-start">
                <x-usuario.creador-modificador :modelo="$user" />
            </div>
        </div>
        <div class="absolute top-5 right-5">
            @include('usuarios/listado/acciones', ['user' => $user])
        </div>
    </x-card>
@empty
    <x-empty />
@endforelse
