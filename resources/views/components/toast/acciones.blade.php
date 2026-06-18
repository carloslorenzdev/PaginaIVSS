@props(['acciones' => []])

@if (count($acciones))
    <div class="flex justify-start gap-x-4 mt-3">
        @foreach ($acciones as $accion)
            <x-toast.link :ruta="$accion['ruta']" :descripcion="$accion['descripcion']" />
        @endforeach
    </div>
@endif
