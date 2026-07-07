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
                'pregunta' => 'Requisitos PensiÃ³n Vejez Detallado',
                'palabras_clave' => 'pension, vejez, requisitos, jubilacion, edad, aÃ±os, cumplir, solicitar',
                'respuesta' => 'REQUISITOS PARA PENSIÃ“N DE VEJEZ (IVSS):

1. Tener 60 aÃ±os o mÃ¡s (hombres) o 55 aÃ±os o mÃ¡s (mujeres).
2. Haber cotizado un mÃ­nimo de 750 semanas (aproximadamente 14.5 aÃ±os).
3. Estar cesante (no estar laborando activamente).
4. Presentar: cÃ©dula de identidad laminada, constancia de trabajo, solvencia de cotizaciones.

Puedes iniciar el trÃ¡mite en cualquier oficina del IVSS presentando los recaudos. El proceso puede tomar entre 30 y 90 dÃ­as hÃ¡biles.',
                'activo' => true
            ],
            [
                'pregunta' => 'Monto PensiÃ³n Vejez',
                'palabras_clave' => 'pension, vejez, monto, cuanto, pago, bono, cantidad, bolivares',
                'respuesta' => 'El monto de la pensiÃ³n de vejez del IVSS se calcula basado en el promedio de las cotizaciones de los Ãºltimos 5 aÃ±os (250 semanas).

Actualmente, la pensiÃ³n mÃ­nima es equivalente al salario mÃ­nimo nacional. Para conocer tu monto estimado, debes solicitar una liquidaciÃ³n de cotizaciones en la oficina del IVSS.

Los montos se actualizan periÃ³dicamente segÃºn el decreto del Ejecutivo Nacional.',
                'activo' => true
            ],
            [
                'pregunta' => 'Requisitos PensiÃ³n Invalidez',
                'palabras_clave' => 'pension, invalidez, discapacidad, incapacidad, enfermedad, requisitos',
                'respuesta' => 'REQUISITOS PARA PENSIÃ“N POR INVALIDEZ:

1. Tener una disminuciÃ³n de la capacidad fÃ­sica o mental igual o superior al 66%.
2. Haber cotizado al menos 4 semanas en los Ãºltimos 2 aÃ±os.
3. No estar recibiendo otra pensiÃ³n del IVSS.

Documentos necesarios: cÃ©dula de identidad, informes mÃ©dicos originales, historia clÃ­nica, constancia de cotizaciones.

La evaluaciÃ³n la realiza la ComisiÃ³n de EvaluaciÃ³n de Invalidez del IVSS.',
                'activo' => true
            ],
            [
                'pregunta' => 'PensiÃ³n de Sobrevivencia',
                'palabras_clave' => 'pension, sobrevivencia, viudez, viuda, viudo, muerte, fallecimiento, herederos',
                'respuesta' => 'PENSIÃ“N DE SOBREVIVENCIA:

Pueden solicitarla:
- El cÃ³nyuge o viudo(a) que haya vivido en comunidad con el fallecido.
- Los hijos menores de 18 aÃ±os (o hasta 25 aÃ±os si estudian).
- Los padres si dependÃ­an econÃ³micamente del fallecido.

Requisitos: acta de defunciÃ³n, acta de matrimonio, partidas de nacimiento de los hijos, cÃ©dula de identidad del solicitante.

El monto equivale al 60% de la pensiÃ³n que recibÃ­a o hubiera recibido el causante.',
                'activo' => true
            ],
            [
                'pregunta' => 'Incapacidad Parcial',
                'palabras_clave' => 'incapacidad, parcial, accidente, trabajo, laboral, lesion, reposo',
                'respuesta' => 'INCAPACIDAD PARCIAL:

Si sufriste un accidente o enfermedad de origen laboral con secuelas permanentes pero que no te incapacitan totalmente, puedes optar a una indemnizaciÃ³n por incapacidad parcial.

Debes:
1. Acudir a la medicatura del IVSS para evaluaciÃ³n.
2. Presentar informe mÃ©dico detallado.
3. Reporte de la inspectorÃ­a del trabajo.

El monto se calcula segÃºn el porcentaje de discapacidad determinado por los mÃ©dicos del IVSS.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cobro de PensiÃ³n Bancos',
                'palabras_clave' => 'cobro, pension, banco, tarjeta, debito, deposito, retiro, efectivo',
                'respuesta' => 'COBRO DE PENSIÃ“N:

La pensiÃ³n se deposita mensualmente en la cuenta bancaria que hayas registrado en el IVSS. Los bancos autorizados son:
- Banco de Venezuela
- Banco Mercantil
- Banco Provincial
- Banesco
- Banco Nacional de CrÃ©dito

Si no tienes cuenta, puedes solicitar la Tarjeta de DÃ©bito del IVSS.

Las fechas de pago se publican en la pÃ¡gina web del IVSS y suelen ser la primera semana de cada mes.',
                'activo' => true
            ],
            [
                'pregunta' => 'Medicamentos Alto Costo',
                'palabras_clave' => 'medicamentos, alto costo, farmacia, retirar, remedios, tratamiento, oncologicos, VIH',
                'respuesta' => 'MEDICAMENTOS DE ALTO COSTO:

El IVSS suministra medicamentos de alto costo para tratamientos de:
- VIH/SIDA
- CÃ¡ncer (oncolÃ³gicos)
- Enfermedades renales
- Hepatitis B y C
- Artritis reumatoide
- Esclerosis mÃºltiple

Para retirarlos:
1. Acude a la farmacia del hospital IVSS mÃ¡s cercano con tu receta mÃ©dica.
2. Presenta cÃ©dula de identidad y el informe mÃ©dico que justifique el tratamiento.
3. El mÃ©dico del IVSS evaluarÃ¡ tu caso y autorizarÃ¡ la entrega.

Los retiros son mensuales. Debes llevar tu historial mÃ©dico actualizado.',
                'activo' => true
            ],
            [
                'pregunta' => 'Horarios AtenciÃ³n',
                'palabras_clave' => 'horario, atencion, oficina, abierto, horas, dias, horarios',
                'respuesta' => 'HORARIOS DE ATENCIÃ“N DEL IVSS:

Oficinas Administrativas:
- Lunes a Viernes: 8:00 am a 4:00 pm
- SÃ¡bados y Domingos: Cerrado

Centros de Salud (Hospitales y Ambulatorios):
- Emergencias: 24 horas
- Consultas: Lunes a Viernes 7:00 am a 3:00 pm

LÃ­nea TelefÃ³nica 0800-IVSS:
- Lunes a Viernes 8:00 am a 4:00 pm',
                'activo' => true
            ],
            [
                'pregunta' => 'Contacto IVSS',
                'palabras_clave' => 'contacto, telefono, correo, email, whatsapp, comunicarse, atencion',
                'respuesta' => 'CANALES DE CONTACTO DEL IVSS:

TelÃ©fono: 0800-IVSS (0800-48777)
Sitio Web: https://www.ivss.gob.ve
Correo: atencionciudadano@ivss.gob.ve

Redes Sociales:
- Twitter/X: @ivssonline
- Instagram: @ivss_oficial

TambiÃ©n puedes acudir personalmente a cualquiera de nuestras oficinas a nivel nacional.',
                'activo' => true
            ],
            [
                'pregunta' => 'Cambio de Datos',
                'palabras_clave' => 'cambio, datos, actualizar, direccion, telefono, registro, actualizacion',
                'respuesta' => 'ACTUALIZACIÃ“N DE DATOS:

Para actualizar tus datos en el IVSS (direcciÃ³n, telÃ©fono, correo electrÃ³nico):

1. Acude a la oficina del IVSS mÃ¡s cercana con tu cÃ©dula de identidad.
2. Solicita el formulario de actualizaciÃ³n de datos.
3. Completa y entrega el formulario en la misma oficina.

TambiÃ©n puedes hacerlo a travÃ©s de la pÃ¡gina web www.ivss.gob.ve si estÃ¡s registrado en el sistema en lÃ­nea.',
                'activo' => true
            ],
            [
                'pregunta' => 'Certificado de Cotizaciones',
                'palabras_clave' => 'certificado, cotizaciones, solvencia, semanas, cotizadas, historia, laboral',
                'respuesta' => 'CERTIFICADO DE COTIZACIONES:

Puedes solicitar tu historial de cotizaciones o solvencia de semanas cotizadas:

1. En lÃ­nea: A travÃ©s del portal www.ivss.gob.ve (secciÃ³n "Consulta de Cotizaciones").
2. Presencial: En cualquier oficina del IVSS presentando tu cÃ©dula de identidad.

El certificado es necesario para trÃ¡mites de pensiÃ³n, prestaciones sociales y otros beneficios.',
                'activo' => true
            ],
            [
                'pregunta' => 'Prestaciones Sociales',
                'palabras_clave' => 'prestaciones, sociales, liquidacion, antiguedad, fideicomiso',
                'respuesta' => 'PRESTACIONES SOCIALES:

Las prestaciones sociales son un derecho de todo trabajador segÃºn la LOTTT. El IVSS no las paga directamente:

- Son calculadas y pagadas por el empleador al finalizar la relaciÃ³n laboral.
- Equivalen a 30 dÃ­as de salario por cada aÃ±o de servicio.
- El fideicomiso se deposita en el banco que el trabajador elija.

Para mÃ¡s informaciÃ³n, consulta con la InspectorÃ­a del Trabajo de tu localidad.',
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
