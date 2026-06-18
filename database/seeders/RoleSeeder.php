<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // -------------------------------------------------------
            // PERMISOS DEL PANEL ADMINISTRATIVO (PÁGINA WEB)
            // -------------------------------------------------------
            $permisos = [
                // Dashboard
                'admin.panel',

                // Noticias
                'noticias.ver',
                'noticias.crear',
                'noticias.editar',
                'noticias.eliminar',
                'noticias.publicar',
                'noticias.subir_medio',
                'noticias.eliminar_medio',

                // Carrusel
                'carrusel.ver',
                'carrusel.crear',
                'carrusel.editar',
                'carrusel.eliminar',

                // Actividades Anuales
                'actividades.ver',
                'actividades.crear',
                'actividades.editar',
                'actividades.eliminar',
                'actividades.subir_medio',
                'actividades.eliminar_medio',

                // Configuración Visual
                'configuracion.ver',
                'configuracion.editar',
                'configuracion.membrete',
                'configuracion.backgrounds',
                'configuracion.enlaces',
                'configuracion.modulos',

                // Usuarios (gestión completa)
                'usuarios.ver',
                'usuarios.crear',
                'usuarios.editar',
                'usuarios.eliminar',
                'usuarios.toggle_estado',

                // Sistema / Rendimiento
                'sistema.logs',
                'sistema.rendimiento',
                'sistema.cache',

                // Categorias
                'categorias.ver',
                'categorias.crear',
                'categorias.editar',
                'categorias.eliminar',
            ];

            foreach ($permisos as $permiso) {
                Permission::firstOrCreate(['name' => $permiso]);
            }

            // -------------------------------------------------------
            // ROLES
            // -------------------------------------------------------

            // Admin de la página web - acceso total
            $rolAdmin = Role::firstOrCreate(['name' => 'admin']);
            $rolAdmin->syncPermissions(Permission::all());

            // Redactor - puede crear/editar noticias y actividades, NO configuración ni usuarios
            $rolRedactor = Role::firstOrCreate(['name' => 'redactor']);
            $rolRedactor->syncPermissions([
                'admin.panel',
                'noticias.ver',
                'noticias.crear',
                'noticias.editar',
                'noticias.subir_medio',
                'actividades.ver',
                'actividades.crear',
                'actividades.editar',
                'actividades.subir_medio',
                'carrusel.ver',
                'categorias.ver',
                'categorias.crear',
                'categorias.editar',
            ]);

            // Aprobador - puede publicar/despublicar y eliminar, NO crear
            $rolAprobador = Role::firstOrCreate(['name' => 'aprobador']);
            $rolAprobador->syncPermissions([
                'admin.panel',
                'noticias.ver',
                'noticias.editar',
                'noticias.eliminar',
                'noticias.publicar',
                'noticias.eliminar_medio',
                'actividades.ver',
                'actividades.editar',
                'actividades.eliminar',
                'actividades.eliminar_medio',
                'carrusel.ver',
                'carrusel.crear',
                'carrusel.editar',
                'carrusel.eliminar',
                'categorias.ver',
                'categorias.editar',
                'categorias.eliminar',
            ]);

        });
    }
}
