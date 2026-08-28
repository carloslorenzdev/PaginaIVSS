<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatbotConocimiento;

class ChatbotNuevosConocimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conocimientos = [
            // INFORMACIÓN PENSIÓN
            [
                'pregunta' => '¿Cómo verificar si ya fui asignado en el listado de nuevos pensionados con mi número de cédula?',
                'palabras_clave' => 'pensionado, nuevos pensionados, verificar asignacion, cedula, listado, nuevo pensionado, asignado, pension, incorporar, listado de nuevos',
                'respuesta' => 'Para verificar si fuiste incorporado al sistema, ingresa tu cédula de identidad y fecha de nacimiento en el módulo de consulta de nuestra página web www.ivss.gov.ve. Si apareces asignado, descarga e imprime tu constancia de pensión.',
            ],
            [
                'pregunta' => '¿Cuáles son los requisitos y planillas necesarias para tramitar la pensión por vejez, sobreviviente o invalidez?',
                'palabras_clave' => 'requisitos pension, planillas pension, tramite pension, vejez, sobreviviente, invalidez, forma 14-04, forma 14-100, solicitar pension, recaudos pension, tramitar pension',
                'respuesta' => 'Requisitos principales: Cédula de identidad laminada, forma 14-04 (solicitud de prestaciones dinerarias) o constancia de trabajo (forma 14-100 si aplica). Consigna los recaudos en la oficina administrativa más cercana a tu domicilio.',
            ],
            [
                'pregunta' => '¿Cuál es el cronograma o fecha de pago de la pensión del mes en curso?',
                'palabras_clave' => 'cronograma pago, fecha de pago, dia de pago, pago de pension, cuando pagan la pension, mes en curso, abono pension',
                'respuesta' => 'Las fechas de abono de pensión se anuncian exclusivamente a través de los canales oficiales (@ivss_ve) y el portal institucional. El depósito se realiza de forma directa en tu cuenta bancaria asignada.',
            ],
            [
                'pregunta' => '¿Qué debo hacer si mi cuenta bancaria de pensión fue bloqueada o no recibí el abono correspondiente?',
                'palabras_clave' => 'cuenta bancaria bloqueada, no recibi abono, pension bloqueada, problema de pago, no me cayo la pension, banco bloqueado',
                'respuesta' => 'Dirígete la oficina administrativa más cercana a tu domicilio, no olvides llevar la cédula de identidad.',
            ],
            [
                'pregunta' => '¿Cómo consultar y descargar la constancia de cuenta individual o verificar las semanas cotizadas?',
                'palabras_clave' => 'cuenta individual, semanas cotizadas, constancia cuenta, descargar constancia, consultar cotizaciones, verificar semanas',
                'respuesta' => 'Para verificar tus cotizaciones y cuenta individual, ingresa tu cédula de identidad y fecha de nacimiento en el módulo de consulta de nuestra página web www.ivss.gov.ve.',
            ],

            // MEDICAMENTOS ALTO COSTO
            [
                'pregunta' => '¿Cuáles son los recaudos para abrir expediente por primera vez en la Dirección de Medicamentos de Alto Costo?',
                'palabras_clave' => 'recaudos alto costo, abrir expediente, primera vez alto costo, requisitos medicamentos, farmacia alto costo',
                'respuesta' => 'Para registrarte, presenta en la Farmacia de Alto Costo: informe médico original y actualizado con sello húmedo, récipe médico, copia de cédula de identidad del paciente y ficha farmacológica emitida por el especialista.',
            ],
            [
                'pregunta' => '¿Dónde están ubicadas las Farmacias de Alto Costo a nivel nacional y cuál es su horario de atención?',
                'palabras_clave' => 'ubicacion farmacia alto costo, donde quedan farmacias, direccion alto costo, horario atencion alto costo, a que hora abren, nivel nacional alto costo',
                'respuesta' => 'Las Farmacias de Alto Costo atienden a nivel nacional de lunes a viernes, de 8:00 a.m. a 1:00 p.m. Ingresa a nuestra página web www.ivss.gov.ve y haz clic en Farmacias de Alto Costo allí encontrarás la dirección exacta por estado.',
            ],
            [
                'pregunta' => '¿Qué autorización y documentos debe presentar un familiar para retirar el medicamento en lugar del paciente?',
                'palabras_clave' => 'familiar retirar medicamento, autorizacion, documentos familiar, retirar medicina, en lugar del paciente, carta de autorizacion',
                'respuesta' => 'La persona autorizada debe consignar: carta de autorización simple firmada por el titular, copia de cédula de identidad de ambos y el récipe original actualizado.',
            ],

            // CENTRO DE SALUD CERCANO
            [
                'pregunta' => '¿Qué hospitales, ambulatorios o clínicas populares del IVSS se encuentran disponibles según mi estado o municipio?',
                'palabras_clave' => 'hospitales ivss, ambulatorios ivss, clinicas populares, centros de salud, centro disponibles, ubicacion de hospitales',
                'respuesta' => 'Ingresa a nuestra página web www.ivss.gov.ve y haz clic en Centros de Salud allí encontrarás la dirección exacta por estado.',
            ],

            // HEMODIÁLISIS
            [
                'pregunta' => '¿Cuáles son los requisitos para registrar a un paciente renal y solicitar asignación de cupo en una unidad de diálisis?',
                'palabras_clave' => 'paciente renal, asignacion de cupo, cupo dialisis, requisitos dialisis, hemodialisis, unidad de dialisis, registrar renal',
                'respuesta' => 'Para gestionar cupo en una unidad intra o extrahospitalaria, consigna: informe nefrológico actualizado, serologías vigentes (VIH, Hepatitis B y C), tipo de acceso vascular y copia de la cédula en la unidad de nefrología regional.',
            ],
            [
                'pregunta' => '¿Dónde consultar el directorio de unidades de nefrología y diálisis adscritas o en convenio con el instituto?',
                'palabras_clave' => 'directorio unidades nefrologia, centros dialisis, convenio ivss, donde consultar dialisis, ubicacion nefrologia, clinicas dialisis',
                'respuesta' => 'Ingresa a nuestra página web www.ivss.gov.ve y haz clic en Centros de Salud allí encontrarás la dirección exacta por estado.',
            ],
            [
                'pregunta' => '¿Cómo gestionar el traslado temporal o definitivo de un paciente a otra unidad de diálisis?',
                'palabras_clave' => 'traslado temporal, traslado definitivo, cambio unidad dialisis, paciente otra unidad, viajar dialisis, mover paciente dialisis',
                'respuesta' => 'Para cambio de centro o traslado temporal por viaje, entrega en tu unidad actual una carta de solicitud con al menos 15 días de anticipación e informe médico del nefrólogo tratante.',
            ],
        ];

        foreach ($conocimientos as $item) {
            ChatbotConocimiento::create([
                'pregunta' => $item['pregunta'],
                'palabras_clave' => $item['palabras_clave'],
                'respuesta' => $item['respuesta'],
                'activo' => true,
            ]);
        }
    }
}
