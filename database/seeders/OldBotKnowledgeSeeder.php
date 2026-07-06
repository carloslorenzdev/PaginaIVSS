<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotConocimiento;

class OldBotKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'pregunta' => 'Pensión Vejez (Requisitos)',
                'palabras_clave' => 'pension, vejez, requisitos, jubilacion, edad, años, cumplir, solicitar',
                'respuesta' => "<b>REQUISITOS PARA PENSIÓN DE VEJEZ (IVSS):</b><br><br>1. Tener 60 años o más (hombres) o 55 años o más (mujeres).<br>2. Haber cotizado un mínimo de 750 semanas (aproximadamente 14.5 años).<br>3. Estar cesante (no estar laborando activamente).<br>4. Presentar: cédula de identidad laminada, constancia de trabajo, solvencia de cotizaciones.<br><br>Puedes iniciar el trámite en cualquier oficina del IVSS presentando los recaudos. El proceso puede tomar entre 30 y 90 días hábiles.",
                'activo' => true,
            ],
            [
                'pregunta' => 'Pensión Vejez (Monto)',
                'palabras_clave' => 'pension, vejez, monto, cuanto, pago, bono, cantidad, bolivares',
                'respuesta' => "El monto de la pensión de vejez del IVSS se calcula basado en el promedio de las cotizaciones de los últimos 5 años (250 semanas).<br><br>Actualmente, la pensión mínima es equivalente al salario mínimo nacional. Para conocer tu monto estimado, debes solicitar una liquidación de cotizaciones en la oficina del IVSS.<br><br>Los montos se actualizan periódicamente según el decreto del Ejecutivo Nacional.",
                'activo' => true,
            ],
            [
                'pregunta' => 'Consulta Estatus Pensionados',
                'palabras_clave' => 'consulta, pensionados, pensionado, estatus, lista, nuevos, consultar, salir',
                'respuesta' => "<b>CONSULTA DE PENSIONADOS:</b><br><br>Si deseas verificar tu estatus como pensionado, consultar si saliste en los nuevos listados de pensionados o imprimir tu constancia, solo necesitas ingresar tu nacionalidad, número de cédula de identidad y fecha de nacimiento en nuestra web.",
                'activo' => true,
            ],
            [
                'pregunta' => 'Información General Institución (Nosotros)',
                'palabras_clave' => 'ivss, nosotros, mision, vision, proposito, que es, sobre, institucion, objetivo, historia',
                'respuesta' => "<b>SOBRE EL IVSS:</b><br><br>El Instituto Venezolano de los Seguros Sociales (IVSS) es una institución pública encargada de brindar protección de Seguridad Social a todos los beneficiarios en las contingencias de maternidad, vejez, sobrevivencia, enfermedad, accidentes, invalidez, muerte, retiro y cesantía o paro forzoso, de manera oportuna y con calidad de excelencia en el servicio.",
                'activo' => true,
            ],
            [
                'pregunta' => 'Canales de Contacto IVSS',
                'palabras_clave' => 'contacto, telefono, correo, email, whatsapp, comunicarse, atencion, hablar, humano, llamar',
                'respuesta' => "<b>CANALES DE CONTACTO DEL IVSS:</b><br><br>Teléfono: 0800-IVSS (0800-48777)<br>Sitio Web: https://www.ivss.gob.ve<br>Correo: atencionciudadano@ivss.gob.ve<br><br>Redes Sociales:<br>- Twitter/X: @ivssonline<br>- Instagram: @ivss_oficial<br><br>También puedes acudir personalmente a cualquiera de nuestras oficinas a nivel nacional.",
                'activo' => true,
            ],
            [
                'pregunta' => 'Trámites en General',
                'palabras_clave' => 'tramites, gestiones, hacer, solicitud, pedir, gestionar, planillas',
                'respuesta' => "<b>TRÁMITES DEL IVSS:</b><br><br>Ofrecemos diversas secciones para facilitar tus trámites:<br>- Para trabajadores: Consultas de Cuenta Individual e impresión de constancias.<br>- Para empleadores: Sistema Tiuna para registro, afiliaciones y pagos.<br>- Para pensionados: Consultas de estatus y recibos de pago.",
                'activo' => true,
            ]
        ];

        // Se excluyen los que ya inserté en el seeder anterior (Tiuna, Cuenta Individual, Constancias) porque 
        // ya están configurados con un formato igual o mejor en el nuevo bot, para evitar duplicados.

        foreach ($data as $item) {
            // Avoid exact duplicates by intent string match on keywords just in case
            if (!ChatbotConocimiento::where('palabras_clave', $item['palabras_clave'])->exists()) {
                ChatbotConocimiento::create($item);
            }
        }
    }
}
