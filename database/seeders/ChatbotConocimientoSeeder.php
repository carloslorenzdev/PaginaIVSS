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
                'respuesta' => 'Sistema Tiuna (Registro de Empresas y Empleadores):

El Sistema Tiuna es la plataforma oficial del IVSS para empleadores. A través de él puedes:
- Registrar una nueva empresa
- Afiliar nuevos trabajadores
- Pagar la factura mensual

Para continuar, dirígete a la sección "Sistema Tiuna" en el menú de la página principal.',
                'activo' => true
            ],
            [
                'pregunta' => 'Requisitos Pensión de Vejez',
                'palabras_clave' => 'pension, vejez, jubilado, abuelo, tercera edad, requisitos',
                'respuesta' => 'Requisitos para Pensión de Vejez:

1. 60 años (hombres) o 55 años (mujeres).
2. Mínimo de 750 semanas cotizadas.
3. Presentar: cédula, constancia de trabajo y solvencia.

Para consultar tu estatus, busca la sección "Pensionados" en el menú de consultas.',
                'activo' => true
            ],
            [
                'pregunta' => 'Constancias',
                'palabras_clave' => 'constancia, recibo, comprobante, imprimir, descargar',
                'respuesta' => 'Constancias del IVSS:

Puedes generar y descargar constancias electrónicas gratuitas, como Constancia de Pensionado o Cuenta Individual, totalmente válidas legalmente.

Accede a la sección "Constancias" para generarlas.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cuenta Individual',
                'palabras_clave' => 'cuenta, individual, semana, cotizacion, cotizadas, historial',
                'respuesta' => 'Consulta de Cuenta Individual:

Aquí puedes revisar tu historial laboral, semanas cotizadas y salarios declarados. Solo necesitas tu cédula y fecha de nacimiento.

Dirígete a la sección "Cuenta Individual" para consultarla.',
                'activo' => true
            ],
            [
                'pregunta' => 'Recursos Humanos',
                'palabras_clave' => 'rrhh, recurso, humanos, empleado publico, trabajador ivss',
                'respuesta' => 'Servicios al Funcionario (RRHH):

Si eres trabajador activo o jubilado directo del IVSS, puedes acceder a la sección de Recursos Humanos para gestionar tus solicitudes, recibos de pago y demás beneficios.

Dirígete al apartado de "Servicios Complementarios" y haz clic en "Servicios al Funcionario" para iniciar sesión en tu portal.',
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
