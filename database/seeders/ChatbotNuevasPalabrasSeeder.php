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
                'respuesta' => '<b>REQUISITOS PARA PENSIÓN DE VEJEZ (IVSS):</b><br><br>1. Tener 60 años o más (hombres) o 55 años o más (mujeres).<br>2. Haber cotizado un mínimo de 750 semanas (aproximadamente 14.5 años).<br>3. Estar cesante (no estar laborando activamente).<br>4. Presentar: cédula de identidad laminada, constancia de trabajo, solvencia de cotizaciones.<br><br>Puedes iniciar el trámite en cualquier oficina del IVSS presentando los recaudos. El proceso puede tomar entre 30 y 90 días hábiles.',
                'activo' => true
            ],
            [
                'pregunta' => 'Monto Pensión Vejez',
                'palabras_clave' => 'pension, vejez, monto, cuanto, pago, bono, cantidad, bolivares',
                'respuesta' => 'El monto de la pensión de vejez del IVSS se calcula basado en el promedio de las cotizaciones de los últimos 5 años (250 semanas).<br><br>Actualmente, la pensión mínima es equivalente al salario mínimo nacional. Para conocer tu monto estimado, debes solicitar una liquidación de cotizaciones en la oficina del IVSS.<br><br>Los montos se actualizan periódicamente según el decreto del Ejecutivo Nacional.',
                'activo' => true
            ],
            [
                'pregunta' => 'Requisitos Pensión Invalidez',
                'palabras_clave' => 'pension, invalidez, discapacidad, incapacidad, enfermedad, requisitos',
                'respuesta' => '<b>REQUISITOS PARA PENSIÓN POR INVALIDEZ:</b><br><br>1. Tener una disminución de la capacidad física o mental igual o superior al 66%.<br>2. Haber cotizado al menos 4 semanas en los últimos 2 años.<br>3. No estar recibiendo otra pensión del IVSS.<br><br>Documentos necesarios: cédula de identidad, informes médicos originales, historia clínica, constancia de cotizaciones.<br><br>La evaluación la realiza la Comisión de Evaluación de Invalidez del IVSS.',
                'activo' => true
            ],
            [
                'pregunta' => 'Pensión de Sobrevivencia',
                'palabras_clave' => 'pension, sobrevivencia, viudez, viuda, viudo, muerte, fallecimiento, herederos',
                'respuesta' => '<b>PENSIÓN DE SOBREVIVENCIA:</b><br><br>Pueden solicitarla:<br>- El cónyuge o viudo(a) que haya vivido en comunidad con el fallecido.<br>- Los hijos menores de 18 años (o hasta 25 años si estudian).<br>- Los padres si dependían económicamente del fallecido.<br><br>Requisitos: acta de defunción, acta de matrimonio, partidas de nacimiento de los hijos, cédula de identidad del solicitante.<br><br>El monto equivale al 60% de la pensión que recibía o hubiera recibido el causante.',
                'activo' => true
            ],
            [
                'pregunta' => 'Incapacidad Parcial',
                'palabras_clave' => 'incapacidad, parcial, accidente, trabajo, laboral, lesion, reposo',
                'respuesta' => '<b>INCAPACIDAD PARCIAL:</b><br><br>Si sufriste un accidente o enfermedad de origen laboral con secuelas permanentes pero que no te incapacitan totalmente, puedes optar a una indemnización por incapacidad parcial.<br><br>Debes:<br>1. Acudir a la medicatura del IVSS para evaluación.<br>2. Presentar informe médico detallado.<br>3. Reporte de la inspectoría del trabajo.<br><br>El monto se calcula según el porcentaje de discapacidad determinado por los médicos del IVSS.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cobro de Pensión Bancos',
                'palabras_clave' => 'cobro, pension, banco, tarjeta, debito, deposito, retiro, efectivo',
                'respuesta' => '<b>COBRO DE PENSIÓN:</b><br><br>La pensión se deposita mensualmente en la cuenta bancaria que hayas registrado en el IVSS. Los bancos autorizados son:<br>- Banco de Venezuela<br>- Banco Mercantil<br>- Banco Provincial<br>- Banesco<br>- Banco Nacional de Crédito<br><br>Si no tienes cuenta, puedes solicitar la Tarjeta de Débito del IVSS.<br><br>Las fechas de pago se publican en la página web del IVSS y suelen ser la primera semana de cada mes.',
                'activo' => true
            ],
            [
                'pregunta' => 'Medicamentos Alto Costo',
                'palabras_clave' => 'medicamentos, alto costo, farmacia, retirar, remedios, tratamiento, oncologicos, VIH',
                'respuesta' => '<b>MEDICAMENTOS DE ALTO COSTO:</b><br><br>El IVSS suministra medicamentos de alto costo para tratamientos de:<br>- VIH/SIDA<br>- Cáncer (oncológicos)<br>- Enfermedades renales<br>- Hepatitis B y C<br>- Artritis reumatoide<br>- Esclerosis múltiple<br><br>Para retirarlos:<br>1. Acude a la farmacia del hospital IVSS más cercano con tu receta médica.<br>2. Presenta cédula de identidad y el informe médico que justifique el tratamiento.<br>3. El médico del IVSS evaluará tu caso y autorizará la entrega.<br><br>Los retiros son mensuales. Debes llevar tu historial médico actualizado.',
                'activo' => true
            ],
            [
                'pregunta' => 'Horarios Atención',
                'palabras_clave' => 'horario, atencion, oficina, abierto, horas, dias, horarios',
                'respuesta' => '<b>HORARIOS DE ATENCIÓN DEL IVSS:</b><br><br><b>Oficinas Administrativas:</b><br>- Lunes a Viernes: 8:00 am a 4:00 pm<br>- Sábados y Domingos: Cerrado<br><br><b>Centros de Salud (Hospitales y Ambulatorios):</b><br>- Emergencias: 24 horas<br>- Consultas: Lunes a Viernes 7:00 am a 3:00 pm<br><br><b>Línea Telefónica 0800-IVSS:</b><br>- Lunes a Viernes 8:00 am a 4:00 pm',
                'activo' => true
            ],
            [
                'pregunta' => 'Contacto IVSS',
                'palabras_clave' => 'contacto, telefono, correo, email, whatsapp, comunicarse, atencion',
                'respuesta' => '<b>CANALES DE CONTACTO DEL IVSS:</b><br><br>Teléfono: 0800-IVSS (0800-48777)<br>Sitio Web: https://www.ivss.gob.ve<br>Correo: atencionciudadano@ivss.gob.ve<br><br>Redes Sociales:<br>- Twitter/X: @ivssonline<br>- Instagram: @ivss_oficial<br><br>También puedes acudir personalmente a cualquiera de nuestras oficinas a nivel nacional.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cambio de Datos',
                'palabras_clave' => 'cambio, datos, actualizar, direccion, telefono, registro, actualizacion',
                'respuesta' => '<b>ACTUALIZACIÓN DE DATOS:</b><br><br>Para actualizar tus datos en el IVSS (dirección, teléfono, correo electrónico):<br><br>1. Acude a la oficina del IVSS más cercana con tu cédula de identidad.<br>2. Solicita el formulario de actualización de datos.<br>3. Completa y entrega el formulario en la misma oficina.<br><br>También puedes hacerlo a través de la página web www.ivss.gob.ve si estás registrado en el sistema en línea.',
                'activo' => true
            ],
            [
                'pregunta' => 'Certificado de Cotizaciones',
                'palabras_clave' => 'certificado, cotizaciones, solvencia, semanas, cotizadas, historia, laboral',
                'respuesta' => '<b>CERTIFICADO DE COTIZACIONES:</b><br><br>Puedes solicitar tu historial de cotizaciones o solvencia de semanas cotizadas:<br><br>1. En línea: A través del portal www.ivss.gob.ve (sección "Consulta de Cotizaciones").<br>2. Presencial: En cualquier oficina del IVSS presentando tu cédula de identidad.<br><br>El certificado es necesario para trámites de pensión, prestaciones sociales y otros beneficios.',
                'activo' => true
            ],
            [
                'pregunta' => 'Prestaciones Sociales',
                'palabras_clave' => 'prestaciones, sociales, liquidacion, antiguedad, fideicomiso',
                'respuesta' => '<b>PRESTACIONES SOCIALES:</b><br><br>Las prestaciones sociales son un derecho de todo trabajador según la LOTTT. El IVSS no las paga directamente:<br><br>- Son calculadas y pagadas por el empleador al finalizar la relación laboral.<br>- Equivalen a 30 días de salario por cada año de servicio.<br>- El fideicomiso se deposita en el banco que el trabajador elija.<br><br>Para más información, consulta con la Inspectoría del Trabajo de tu localidad.',
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
