<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotConocimiento;

class ChatbotConocimientoSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            [
                'pregunta' => 'Sistema Tiuna',
                'palabras_clave' => 'tiuna, empresa, patrono, registrar, nomina, trabajador, empleador',
                'respuesta' => '<b>Sistema Tiuna (Registro de Empresas y Empleadores):</b><br><br>El Sistema Tiuna es la plataforma oficial del IVSS para empleadores. A través de él puedes:<br>- Registrar una nueva empresa<br>- Afiliar nuevos trabajadores<br>- Pagar la factura mensual<br><br>Para continuar, dirígete a la sección <b>"Sistema Tiuna"</b> en el menú de la página principal.',
                'activo' => true
            ],
            [
                'pregunta' => 'Requisitos Pensión de Vejez',
                'palabras_clave' => 'pension, vejez, jubilado, abuelo, tercera edad, requisitos',
                'respuesta' => '<b>Requisitos para Pensión de Vejez:</b><br><br>1. 60 años (hombres) o 55 años (mujeres).<br>2. Mínimo de 750 semanas cotizadas.<br>3. Presentar: cédula, constancia de trabajo y solvencia.<br><br>Para consultar tu estatus, busca la sección <b>"Pensionados"</b> en el menú de consultas.',
                'activo' => true
            ],
            [
                'pregunta' => 'Constancias',
                'palabras_clave' => 'constancia, recibo, comprobante, imprimir, descargar',
                'respuesta' => '<b>Constancias del IVSS:</b><br><br>Puedes generar y descargar constancias electrónicas gratuitas, como Constancia de Pensionado o Cuenta Individual, totalmente válidas legalmente.<br><br>Accede a la sección <b>"Constancias"</b> para generarlas.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cuenta Individual',
                'palabras_clave' => 'cuenta, individual, semana, cotizacion, cotizadas, historial',
                'respuesta' => '<b>Consulta de Cuenta Individual:</b><br><br>Aquí puedes revisar tu historial laboral, semanas cotizadas y salarios declarados. Solo necesitas tu cédula y fecha de nacimiento.<br><br>Dirígete a la sección <b>"Cuenta Individual"</b> para consultarla.',
                'activo' => true
            ],
            [
                'pregunta' => 'Recursos Humanos',
                'palabras_clave' => 'rrhh, recurso, humanos, empleado publico, trabajador ivss',
                'respuesta' => '<b>Servicios al Funcionario (RRHH):</b><br><br>Si eres trabajador activo o jubilado directo del IVSS, puedes acceder a la sección de Recursos Humanos para gestionar tus solicitudes, recibos de pago y demás beneficios.<br><br>Dirígete al apartado de <b>"Servicios Complementarios"</b> y haz clic en <b>"Servicios al Funcionario"</b> para iniciar sesión en tu portal.',
                'activo' => true
            ],
            [
                'pregunta' => 'Saludos Básicos',
                'palabras_clave' => 'hola, buenos dias, buenas tardes, saludo',
                'respuesta' => '¡Hola! Qué gusto saludarte. Soy el Asistente del IVSS. Puedo brindarte información sobre Farmacias, Hospitales, y guiarte por la página. ¿En qué trámite te puedo asesorar el día de hoy?',
                'activo' => true
            ],
            [
                'pregunta' => 'Agradecimientos',
                'palabras_clave' => 'gracias, excelente',
                'respuesta' => '¡Con todo el gusto! Estamos para servirte.',
                'activo' => true
            ]
        ];

        foreach ($datos as $item) {
            ChatbotConocimiento::create($item);
        }
    }
}
