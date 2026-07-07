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

El Sistema Tiuna es la plataforma oficial del IVSS para empleadores. A travÃ©s de Ã©l puedes:
- Registrar una nueva empresa
- Afiliar nuevos trabajadores
- Pagar la factura mensual

Para continuar, dirÃ­gete a la secciÃ³n "Sistema Tiuna" en el menÃº de la pÃ¡gina principal.',
                'activo' => true
            ],
            [
                'pregunta' => 'Requisitos PensiÃ³n de Vejez',
                'palabras_clave' => 'pension, vejez, jubilado, abuelo, tercera edad, requisitos',
                'respuesta' => 'Requisitos para PensiÃ³n de Vejez:

1. 60 aÃ±os (hombres) o 55 aÃ±os (mujeres).
2. MÃ­nimo de 750 semanas cotizadas.
3. Presentar: cÃ©dula, constancia de trabajo y solvencia.

Para consultar tu estatus, busca la secciÃ³n "Pensionados" en el menÃº de consultas.',
                'activo' => true
            ],
            [
                'pregunta' => 'Constancias',
                'palabras_clave' => 'constancia, recibo, comprobante, imprimir, descargar',
                'respuesta' => 'Constancias del IVSS:

Puedes generar y descargar constancias electrÃ³nicas gratuitas, como Constancia de Pensionado o Cuenta Individual, totalmente vÃ¡lidas legalmente.

Accede a la secciÃ³n "Constancias" para generarlas.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cuenta Individual',
                'palabras_clave' => 'cuenta, individual, semana, cotizacion, cotizadas, historial',
                'respuesta' => 'Consulta de Cuenta Individual:

AquÃ­ puedes revisar tu historial laboral, semanas cotizadas y salarios declarados. Solo necesitas tu cÃ©dula y fecha de nacimiento.

DirÃ­gete a la secciÃ³n "Cuenta Individual" para consultarla.',
                'activo' => true
            ],
            [
                'pregunta' => 'Recursos Humanos',
                'palabras_clave' => 'rrhh, recurso, humanos, empleado publico, trabajador ivss',
                'respuesta' => 'Servicios al Funcionario (RRHH):

Si eres trabajador activo o jubilado directo del IVSS, puedes acceder a la secciÃ³n de Recursos Humanos para gestionar tus solicitudes, recibos de pago y demÃ¡s beneficios.

DirÃ­gete al apartado de "Servicios Complementarios" y haz clic en "Servicios al Funcionario" para iniciar sesiÃ³n en tu portal.',
                'activo' => true
            ],
            [
                'pregunta' => 'Saludos BÃ¡sicos',
                'palabras_clave' => 'hola, buenos dias, buenas tardes, saludo',
                'respuesta' => 'Â¡Hola! QuÃ© gusto saludarte. Soy el Asistente del IVSS. Puedo brindarte informaciÃ³n sobre Farmacias, Hospitales, y guiarte por la pÃ¡gina. Â¿En quÃ© trÃ¡mite te puedo asesorar el dÃ­a de hoy?',
                'activo' => true
            ],
            [
                'pregunta' => 'Agradecimientos',
                'palabras_clave' => 'gracias, excelente',
                'respuesta' => 'Â¡Con todo el gusto! Estamos para servirte.',
                'activo' => true
            ]
        ];

        foreach ($datos as $item) {
            ChatbotConocimiento::create($item);
        }
    }
}
