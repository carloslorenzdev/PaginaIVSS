<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatbotConocimiento;

class ChatbotNuevasPalabrasSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            [
                'pregunta' => 'Requisitos Pensión Vejez Detallado',
                'palabras_clave' => 'pension, vejez, requisitos, jubilacion, edad, años, cumplir, solicitar',
                'respuesta' => 'REQUISITOS PARA PENSIÓN DE VEJEZ (IVSS):

1. Tener 60 años o más (hombres) o 55 años o más (mujeres).
2. Haber cotizado un mínimo de 750 semanas (aproximadamente 14.5 años).
3. Estar cesante (no estar laborando activamente).
4. Presentar: cédula de identidad laminada, constancia de trabajo, solvencia de cotizaciones.

Puedes iniciar el trámite en cualquier oficina del IVSS presentando los recaudos. El proceso puede tomar entre 30 y 90 días hábiles.',
                'activo' => true
            ],
            [
                'pregunta' => 'Monto Pensión Vejez',
                'palabras_clave' => 'pension, vejez, monto, cuanto, pago, bono, cantidad, bolivares',
                'respuesta' => 'El monto de la pensión de vejez del IVSS se calcula basado en el promedio de las cotizaciones de los últimos 5 años (250 semanas).

Actualmente, la pensión mínima es equivalente al salario mínimo nacional. Para conocer tu monto estimado, debes solicitar una liquidación de cotizaciones en la oficina del IVSS.

Los montos se actualizan periódicamente según el decreto del Ejecutivo Nacional.',
                'activo' => true
            ],
            [
                'pregunta' => 'Requisitos Pensión Invalidez',
                'palabras_clave' => 'pension, invalidez, discapacidad, incapacidad, enfermedad, requisitos',
                'respuesta' => 'REQUISITOS PARA PENSIÓN POR INVALIDEZ:

1. Tener una disminución de la capacidad física o mental igual o superior al 66%.
2. Haber cotizado al menos 4 semanas en los últimos 2 años.
3. No estar recibiendo otra pensión del IVSS.

Documentos necesarios: cédula de identidad, informes médicos originales, historia clínica, constancia de cotizaciones.

La evaluación la realiza la Comisión de Evaluación de Invalidez del IVSS.',
                'activo' => true
            ],
            [
                'pregunta' => 'Pensión de Sobrevivencia',
                'palabras_clave' => 'pension, sobrevivencia, viudez, viuda, viudo, muerte, fallecimiento, herederos',
                'respuesta' => 'PENSIÓN DE SOBREVIVENCIA:

Pueden solicitarla:
- El cónyuge o viudo(a) que haya vivido en comunidad con el fallecido.
- Los hijos menores de 18 años (o hasta 25 años si estudian).
- Los padres si dependían económicamente del fallecido.

Requisitos: acta de defunción, acta de matrimonio, partidas de nacimiento de los hijos, cédula de identidad del solicitante.

El monto equivale al 60% de la pensión que recibía o hubiera recibido el causante.',
                'activo' => true
            ],
            [
                'pregunta' => 'Incapacidad Parcial',
                'palabras_clave' => 'incapacidad, parcial, accidente, trabajo, laboral, lesion, reposo',
                'respuesta' => 'INCAPACIDAD PARCIAL:

Si sufriste un accidente o enfermedad de origen laboral con secuelas permanentes pero que no te incapacitan totalmente, puedes optar a una indemnización por incapacidad parcial.

Debes:
1. Acudir a la medicatura del IVSS para evaluación.
2. Presentar informe médico detallado.
3. Reporte de la inspectoría del trabajo.

El monto se calcula según el porcentaje de discapacidad determinado por los médicos del IVSS.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cobro de Pensión Bancos',
                'palabras_clave' => 'cobro, pension, banco, tarjeta, debito, deposito, retiro, efectivo',
                'respuesta' => 'COBRO DE PENSIÓN:

La pensión se deposita mensualmente en la cuenta bancaria que hayas registrado en el IVSS. Los bancos autorizados son:
- Banco de Venezuela
- Banco Mercantil
- Banco Provincial
- Banesco
- Banco Nacional de Crédito

Si no tienes cuenta, puedes solicitar la Tarjeta de Débito del IVSS.

Las fechas de pago se publican en la página web del IVSS y suelen ser la primera semana de cada mes.',
                'activo' => true
            ],
            [
                'pregunta' => 'Medicamentos Alto Costo',
                'palabras_clave' => 'medicamentos, alto costo, farmacia, retirar, remedios, tratamiento, oncologicos, VIH',
                'respuesta' => 'MEDICAMENTOS DE ALTO COSTO:

El IVSS suministra medicamentos de alto costo para tratamientos de:
- VIH/SIDA
- Cáncer (oncológicos)
- Enfermedades renales
- Hepatitis B y C
- Artritis reumatoide
- Esclerosis múltiple

Para retirarlos:
1. Acude a la farmacia del hospital IVSS más cercano con tu receta médica.
2. Presenta cédula de identidad y el informe médico que justifique el tratamiento.
3. El médico del IVSS evaluará tu caso y autorizará la entrega.

Los retiros son mensuales. Debes llevar tu historial médico actualizado.',
                'activo' => true
            ],
            [
                'pregunta' => 'Horarios Atención',
                'palabras_clave' => 'horario, atencion, oficina, abierto, horas, dias, horarios',
                'respuesta' => 'HORARIOS DE ATENCIÓN DEL IVSS:

Oficinas Administrativas:
- Lunes a Viernes: 8:00 am a 4:00 pm
- Sábados y Domingos: Cerrado

Centros de Salud (Hospitales y Ambulatorios):
- Emergencias: 24 horas
- Consultas: Lunes a Viernes 7:00 am a 3:00 pm

Línea Telefónica 0800-IVSS:
- Lunes a Viernes 8:00 am a 4:00 pm',
                'activo' => true
            ],
            [
                'pregunta' => 'Contacto IVSS',
                'palabras_clave' => 'contacto, telefono, correo, email, whatsapp, comunicarse, atencion',
                'respuesta' => 'CANALES DE CONTACTO DEL IVSS:

Teléfono: 0800-IVSS (0800-48777)
Sitio Web: https://www.ivss.gob.ve
Correo: atencionciudadano@ivss.gob.ve

Redes Sociales:
- Twitter/X: @ivssonline
- Instagram: @ivss_oficial

También puedes acudir personalmente a cualquiera de nuestras oficinas a nivel nacional.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cambio de Datos',
                'palabras_clave' => 'cambio, datos, actualizar, direccion, telefono, registro, actualizacion',
                'respuesta' => 'ACTUALIZACIÓN DE DATOS:

Para actualizar tus datos en el IVSS (dirección, teléfono, correo electrónico):

1. Acude a la oficina del IVSS más cercana con tu cédula de identidad.
2. Solicita el formulario de actualización de datos.
3. Completa y entrega el formulario en la misma oficina.

También puedes hacerlo a través de la página web www.ivss.gob.ve si estás registrado en el sistema en línea.',
                'activo' => true
            ],
            [
                'pregunta' => 'Certificado de Cotizaciones',
                'palabras_clave' => 'certificado, cotizaciones, solvencia, semanas, cotizadas, historia, laboral',
                'respuesta' => 'CERTIFICADO DE COTIZACIONES:

Puedes solicitar tu historial de cotizaciones o solvencia de semanas cotizadas:

1. En línea: A través del portal www.ivss.gob.ve (sección "Consulta de Cotizaciones").
2. Presencial: En cualquier oficina del IVSS presentando tu cédula de identidad.

El certificado es necesario para trámites de pensión, prestaciones sociales y otros beneficios.',
                'activo' => true
            ],
            [
                'pregunta' => 'Prestaciones Sociales',
                'palabras_clave' => 'prestaciones, sociales, liquidacion, antiguedad, fideicomiso',
                'respuesta' => 'PRESTACIONES SOCIALES:

Las prestaciones sociales son un derecho de todo trabajador según la LOTTT. El IVSS no las paga directamente:

- Son calculadas y pagadas por el empleador al finalizar la relación laboral.
- Equivalen a 30 días de salario por cada año de servicio.
- El fideicomiso se deposita en el banco que el trabajador elija.

Para más información, consulta con la Inspectoría del Trabajo de tu localidad.',
                'activo' => true
            ],
        ];

        foreach ($datos as $item) {
            ChatbotConocimiento::updateOrCreate(
                ['pregunta' => $item['pregunta']],
                $item
            );
        }
    }
}
