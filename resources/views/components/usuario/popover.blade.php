@props(['usuario' => null, 'trigger' => 'hover'])

@if ($usuario)
    <x-popover {{ $attributes }} trigger="{{ $trigger }}">
        <x-avatar.item class="hover:cursor-pointer" descripcion="{{ $usuario->iniciales }}" />
        <x-slot:header>
            <a href="{{ route('usuarios.detalle', $usuario) }}" class="flex items-center gap-x-3 hover:underline">
                <x-avatar.item class="shink-0" size="size-10" descripcion="{{ $usuario->iniciales }}" />
                <x-popover.titulo titulo="{{ $usuario->nombreApellido }}" subtitulo="{{ $usuario->usuario }}" />
            </a>
        </x-slot:header>
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-popover>
@endif
