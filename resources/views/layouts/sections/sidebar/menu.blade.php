{{-- ====================================================
     SIDEBAR MENU - Panel Administrativo Página IVSS
     ==================================================== --}}

{{-- DASHBOARD --}}
<li>
    <x-nav.link href="{{ route('admin.panel') }}" active="{{ routeActive('admin.panel') }}">
        <i class="bx bx-tachometer bx-sm"></i>
        Dashboard
    </x-nav.link>
</li>

{{-- NOTICIAS --}}
@can('noticias.ver')
<li>
    <x-nav.accordion id="noticias-acordion" active="{{ routeActive('admin.noticias.*') }}">
        <x-slot:heading>
            <i class="bx bx-news bx-sm"></i>
            Noticias
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            <li>
                <x-nav.link href="{{ route('admin.panel') }}" active="{{ routeActive('admin.panel') }}">
                    Listado
                </x-nav.link>
            </li>
            @can('noticias.crear')
            <li>
                <x-nav.link href="{{ route('admin.noticias.crear') }}" active="{{ routeActive('admin.noticias.crear') }}">
                    Nueva Noticia
                </x-nav.link>
            </li>
            @endcan
        </ul>
    </x-nav.accordion>
</li>
@endcan

{{-- BOLETINES --}}
@can('boletines.ver')
<li>
    <x-nav.link href="{{ route('admin.boletines.index') }}" active="{{ routeActive('admin.boletines.*') }}">
        <i class="bx bx-news bx-sm"></i>
        Boletines Informativos
    </x-nav.link>
</li>
@endcan

{{-- REVISTAS DIGITALES --}}
@can('revistas.ver')
<li>
    <x-nav.link href="{{ route('admin.revistas.index') }}" active="{{ routeActive('admin.revistas.*') }}">
        <i class="bx bx-book-open bx-sm"></i>
        Revistas Digitales
    </x-nav.link>
</li>
@endcan

{{-- CATEGORÍAS --}}
@can('categorias.ver')
<li>
    <x-nav.accordion id="categorias-acordion" active="{{ routeActive('admin.categorias.*') }}">
        <x-slot:heading>
            <i class="bx bx-purchase-tag-alt bx-sm"></i>
            Categorías
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            <li>
                <x-nav.link href="{{ route('admin.categorias.index') }}" active="{{ routeActive('admin.categorias.index') }}">
                    Listado
                </x-nav.link>
            </li>
            @can('categorias.crear')
            <li>
                <x-nav.link href="{{ route('admin.categorias.crear') }}" active="{{ routeActive('admin.categorias.crear') }}">
                    Nueva Categoría
                </x-nav.link>
            </li>
            @endcan
        </ul>
    </x-nav.accordion>
</li>
@endcan

{{-- CARRUSEL --}}
@can('carrusel.ver')
<li>
    <x-nav.link href="{{ route('admin.carrusel.gestionar') }}" active="{{ routeActive('admin.carrusel.*') }}">
        <i class="bx bx-slideshow bx-sm"></i>
        Carrusel
    </x-nav.link>
</li>
@endcan

{{-- BANNERS Y ALERTAS --}}
@can('banners.ver')
<li>
    <x-nav.link href="{{ route('admin.banners.index') }}" active="{{ routeActive('admin.banners.*') }}">
        <i class="bx bx-image-alt bx-sm"></i>
        Banners y Alertas
    </x-nav.link>
</li>
@endhasrole

{{-- ACTIVIDADES ANUALES --}}
@can('actividades.ver')
<li>
    <x-nav.accordion id="actividades-acordion" active="{{ routeActive('admin.actividades.*') }}">
        <x-slot:heading>
            <i class="bx bx-calendar-event bx-sm"></i>
            Actividades
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            <li>
                <x-nav.link href="{{ route('admin.actividades.index') }}" active="{{ routeActive('admin.actividades.index') }}">
                    Listado
                </x-nav.link>
            </li>
            @can('actividades.crear')
            <li>
                <x-nav.link href="{{ route('admin.actividades.crear') }}" active="{{ routeActive('admin.actividades.crear') }}">
                    Nueva Actividad
                </x-nav.link>
            </li>
            @endcan
        </ul>
    </x-nav.accordion>
</li>
@endcan

{{-- DIRECTORIOS --}}
@can('directorios.ver')
<li>
    <x-nav.accordion id="directorios-acordion" active="{{ request()->routeIs('admin.directorios.*') }}">
        <x-slot:heading>
            <i class="bx bx-buildings bx-sm"></i>
            Directorios
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            <li>
                <x-nav.link href="{{ route('admin.directorios.index', ['tipo' => 'farmacia']) }}" active="{{ request('tipo') == 'farmacia' }}">
                    Farmacias
                </x-nav.link>
            </li>
            <li>
                <x-nav.link href="{{ route('admin.directorios.index', ['tipo' => 'centro_salud']) }}" active="{{ request('tipo') == 'centro_salud' }}">
                    Centros de Salud
                </x-nav.link>
            </li>
            <li>
                <x-nav.link href="{{ route('admin.directorios.index', ['tipo' => 'oficina_administrativa']) }}" active="{{ request('tipo') == 'oficina_administrativa' }}">
                    Oficinas Administrativas
                </x-nav.link>
            </li>
        </ul>
    </x-nav.accordion>
</li>
@endcan

@canany(['chatbot_conocimiento.ver', 'chatbot_preguntas.ver'])
<li>
    <x-nav.accordion id="chatbot-acordion" active="{{ request()->routeIs('admin.chatbot.*') }}">
        <x-slot:heading>
            <i class="bx bx-bot bx-sm"></i>
            Chatbot Asistente
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            @can('chatbot_conocimiento.ver')
            <li>
                <x-nav.link href="{{ route('admin.chatbot.conocimiento.index') }}" active="{{ request()->routeIs('admin.chatbot.conocimiento.*') }}">
                    Base de Conocimientos
                </x-nav.link>
            </li>
            @endcan
            @can('chatbot_preguntas.ver')
            <li>
                <x-nav.link href="{{ route('admin.chatbot.preguntas-sin-respuesta.index') }}" active="{{ request()->routeIs('admin.chatbot.preguntas-sin-respuesta.*') }}">
                    Preguntas sin Respuesta
                </x-nav.link>
            </li>
            @endcan
        </ul>
    </x-nav.accordion>
</li>
@endcanany

@can('configuracion.ver')
<li>
    <x-nav.accordion id="config-acordion" active="{{ routeActive('admin.config.*') }}">
        <x-slot:heading>
            <i class="bx bx-palette bx-sm"></i>
            Configuración
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            <li>
                <x-nav.link href="{{ route('admin.config.visual') }}" active="{{ routeActive('admin.config.visual') }}">
                    Visual del Sitio
                </x-nav.link>
            </li>
            <li>
                <x-nav.link href="{{ route('admin.config.enlaces') }}" active="{{ routeActive('admin.config.enlaces') }}">
                    Enlaces
                </x-nav.link>
            </li>
        </ul>
    </x-nav.accordion>
</li>
@endcan

{{-- USUARIOS --}}
@can('usuarios.ver')
<li>
    <x-nav.accordion id="usuarios-acordion" active="{{ routeActive(['usuarios.*', 'usuarios.roles.*', 'usuarios.control_acceso.*']) }}">
        <x-slot:heading>
            <x-iconos.users />
            Usuarios
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            <li>
                <x-nav.link href="{{ route('usuarios.listado') }}" active="{{ routeActive('usuarios.listado') }}" data-turbo="false">
                    Listado
                </x-nav.link>
            </li>
            @hasrole('admin')
            <li>
                <x-nav.link href="{{ route('usuarios.roles.index') }}" active="{{ routeActive('usuarios.roles.*') }}">
                    Roles
                </x-nav.link>
            </li>
            <li>
                <x-nav.link href="{{ route('usuarios.control_acceso.index') }}" active="{{ routeActive('usuarios.control_acceso.*') }}">
                    Control de Acceso
                </x-nav.link>
            </li>
            @endhasrole
        </ul>
    </x-nav.accordion>
</li>
@endcan

{{-- SISTEMA --}}
@canany(['sistema.rendimiento', 'sistema.logs', 'sistema.cache'])
<li>
    <x-nav.accordion id="sistema-acordion" active="{{ routeActive('sistema.*') }}">
        <x-slot:heading>
            <i class="bx bx-cog"></i>
            Sistema
        </x-slot:heading>
        <ul class="ps-8 pt-1 space-y-1">
            @can('sistema.rendimiento')
            <li>
                <x-nav.link href="{{ route('admin.rendimiento') }}" active="{{ routeActive('admin.rendimiento') }}">
                    Rendimiento
                </x-nav.link>
            </li>
            @endcan
            @can('sistema.logs')
            <li>
                <x-nav.link href="/log-errors">
                    Logs del Sistema
                </x-nav.link>
            </li>
            @endcan
            @can('sistema.cache')
            <li>
                <x-nav.link href="{{ route('sistema.cache.limpiar') }}" active="{{ routeActive('sistema.cache.limpiar') }}">
                    Limpiar Cache
                </x-nav.link>
            </li>
            @endcan
            @hasrole('admin')
            <li>
                <x-nav.link href="{{ route('admin.backups.index') }}" active="{{ routeActive('admin.backups.*') }}">
                    Respaldos
                </x-nav.link>
            </li>
            @endhasrole
        </ul>
    </x-nav.accordion>
</li>
@endcanany

{{-- LOGOUT --}}
<li>
    <form action="{{ route('logout') }}" class="w-full" method="POST">
        @csrf
        <x-button
            class="rounded-lg text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-900 w-full"
            type="submit">
            <i class="bx bx-log-out"></i>
            Salir
        </x-button>
    </form>
</li>
