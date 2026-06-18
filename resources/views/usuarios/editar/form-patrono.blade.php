<div>
    <x-input.label for="nombre" value="Nombre" />
    <x-input type="text" id="nombre" name="nombre" placeholder="Autopartes Y&M 2019"
        value="{{ old('nombre', $usuario->nombre) }}" required error />
</div>
<div>
    <x-input.label for="correo" value="Correo Electrónico" />
    <x-input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com"
        value="{{ old('correo', $usuario->email) }}" required error />
</div>
