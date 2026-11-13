<?php

namespace App\Actions\Consultas;

use FPDF;

class GenerarPlanilla14179PdfAction
{
    /**
     * Genera el PDF oficial de la Forma 14-179 (Autorización para Cobro de Pensión).
     *
     * @param array $datos Datos completos procesados por ConsultarAutorizacionCobroAction
     * @return string Contenido binario del PDF
     */
    public function execute(array $datos): string
    {
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        // 1. Logo institucional
        $logoPath = public_path('imagenes/icono-ivss.png');
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 10, 10, 20);
        }

        // 2. Encabezado institucional
        $pdf->SetFont('Arial', '', 6);
        $pdf->SetXY(32, 10);
        $pdf->Cell(0, 4, $this->encode('REPÚBLICA BOLIVARIANA DE VENEZUELA'), 0, 1, 'L');
        $pdf->SetXY(32, 13.5);
        $pdf->Cell(0, 4, $this->encode('MINISTERIO DEL PODER POPULAR PARA EL PROCESO SOCIAL DE TRABAJO'), 0, 1, 'L');
        $pdf->SetXY(32, 17);
        $pdf->Cell(0, 4, $this->encode('INSTITUTO VENEZOLANO DE LOS SEGUROS SOCIALES'), 0, 1, 'L');
        $pdf->SetXY(32, 20.5);
        $pdf->Cell(0, 4, $this->encode('DIRECCIÓN CENTRAL DE AFILIACIÓN Y PRESTACIONES EN DINERO'), 0, 1, 'L');
        $pdf->SetXY(32, 24);
        $pdf->Cell(0, 4, $this->encode('DIRECCIÓN DE PRESTACIONES'), 0, 1, 'L');

        // 3. Planilla / Forma 14-179
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(150, 10);
        $pdf->Cell(50, 4, 'FORMA 14-179', 0, 1, 'R');

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(150, 15);
        $pdf->Cell(8, 5, $this->encode('Nº'), 0, 0, 'R');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(42, 5, ' ' . ($datos['id'] ?? ''), 1, 1, 'C');

        // 4. Bloque Lugar y Fecha
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(10, 10, 10);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetXY(95, 27);
        $pdf->Cell(70, 5, 'LUGAR', 1, 0, 'C', true);
        $pdf->Cell(35, 5, 'FECHA', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 7.5);
        $pdf->SetXY(95, 32);
        $pdf->Cell(70, 5, $this->encode($datos['lugar'] ?? 'DISTRITO CAPITAL'), 1, 0, 'C');
        $rawFecha = $datos['fecha'] ?? '';
        $fechaFormatted = '';
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $rawFecha, $m)) {
            $fechaFormatted = $m[1] . '/' . $m[2] . '/' . substr($m[3], -2);
        } elseif (!empty($rawFecha)) {
            $ts = strtotime(str_replace('/', '-', $rawFecha));
            $fechaFormatted = $ts ? date('d/m/y', $ts) : $rawFecha;
        }
        $pdf->Cell(35, 5, $fechaFormatted, 1, 1, 'C');

        // 5. Título del Documento
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(10, 33);
        $pdf->Cell(80, 5, $this->encode('AUTORIZACIÓN PARA COBRO DE PENSIÓN'), 0, 1, 'L');

        // Espaciador antes de las secciones
        $pdf->SetY(41);

        // 6. DATOS DEL PENSIONADO
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(190, 5, 'DATOS DEL PENSIONADO', 1, 1, 'C', true);

        $pdf->Cell(130, 4.5, 'NOMBRES Y APELLIDOS', 1, 0, 'C');
        $pdf->Cell(60, 4.5, $this->encode('CÉDULA DE IDENTIDAD'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(130, 5.5, ' ' . $this->encode($datos['nombre_pensionado'] ?? ''), 1, 0, 'L');
        $pdf->Cell(60, 5.5, $this->encode($datos['id_pensionado'] ?? ''), 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(130, 4.5, $this->encode('DIRECCIÓN'), 1, 0, 'C');
        $pdf->Cell(60, 4.5, $this->encode('TELÉFONO'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(130, 5.5, ' ' . $this->encode($datos['direccion_pensionado'] ?? ''), 1, 0, 'L');
        $pdf->Cell(60, 5.5, $this->encode($datos['telefono_pensionado'] ?? ''), 1, 1, 'C');

        $pdf->Ln(3);

        // 7. DATOS DE LA PENSIÓN
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(190, 5, $this->encode('DATOS DE LA PENSIÓN'), 1, 1, 'C', true);

        $pdf->Cell(40, 4.5, 'MONTO MENSUAL', 1, 0, 'C');
        $pdf->Cell(95, 4.5, $this->encode('RESOLUCIÓN NRO'), 1, 0, 'C');
        $pdf->Cell(55, 4.5, $this->encode('RAZÓN SOCIAL'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(10, 5.5, 'Bs.', 1, 0, 'C');
        $pdf->Cell(30, 5.5, (string)($datos['monto_pension'] ?? '130'), 1, 0, 'C');
        $pdf->Cell(95, 5.5, (string)($datos['numero_resolucion'] ?? ''), 1, 0, 'C');
        $pdf->Cell(55, 5.5, $this->encode($datos['razon_social'] ?? 'AMOR MAYOR'), 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 4.5, 'TIPO', 1, 0, 'C');
        $pdf->Cell(95, 4.5, 'ENTIDAD BANCARIA', 1, 0, 'C');
        $pdf->Cell(55, 4.5, $this->encode('NÚMERO DE CUENTA'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(40, 5.5, $this->encode($datos['tipo_display'] ?? 'TRABAJO'), 1, 0, 'C');
        $pdf->Cell(95, 5.5, ' ' . $this->encode($datos['nombre_banco'] ?? ''), 1, 0, 'L');
        $pdf->Cell(55, 5.5, (string)($datos['nro_cuenta'] ?? '00000000000000000000'), 1, 1, 'C');

        $pdf->Ln(3);

        // 8. DATOS DEL AUTORIZADO
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(190, 5, 'DATOS DEL AUTORIZADO', 1, 1, 'C', true);

        $pdf->Cell(130, 4.5, 'NOMBRES Y APELLIDOS', 1, 0, 'C');
        $pdf->Cell(60, 4.5, $this->encode('CÉDULA DE IDENTIDAD'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(130, 5.5, ' ' . $this->encode($datos['nombre_autorizado'] ?? ''), 1, 0, 'L');
        $pdf->Cell(60, 5.5, $this->encode($datos['id_autorizado'] ?? ''), 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(130, 4.5, $this->encode('DIRECCIÓN'), 1, 0, 'C');
        $pdf->Cell(60, 4.5, $this->encode('TELÉFONO'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(130, 5.5, ' ' . $this->encode($datos['direccion_autorizado'] ?? ''), 1, 0, 'L');
        $pdf->Cell(60, 5.5, $this->encode($datos['telefono_autorizado'] ?? ''), 1, 1, 'C');

        $pdf->Ln(3);

        // 9. MENSUALIDADES AUTORIZADAS
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(190, 5, 'MENSUALIDADES AUTORIZADAS', 1, 1, 'C', true);

        $pdf->SetFont('Arial', 'B', 7);
        $anchoMes = 24;
        $anchoAno = 14;

        $pdf->Cell($anchoMes, 5.5, $this->encode($datos['acumulado'] ?? ''), 1, 0, 'C');
        $pdf->Cell($anchoAno, 5.5, (string)($datos['ano_acumulado'] ?? ''), 1, 0, 'C');

        $pdf->Cell($anchoMes, 5.5, $this->encode($datos['mes1'] ?? ''), 1, 0, 'C');
        $pdf->Cell($anchoAno, 5.5, (string)($datos['ano1'] ?? ''), 1, 0, 'C');

        $pdf->Cell($anchoMes, 5.5, $this->encode($datos['mes2'] ?? ''), 1, 0, 'C');
        $pdf->Cell($anchoAno, 5.5, (string)($datos['ano2'] ?? ''), 1, 0, 'C');

        $pdf->Cell($anchoMes, 5.5, $this->encode($datos['mes3'] ?? ''), 1, 0, 'C');
        $pdf->Cell($anchoAno, 5.5, (string)($datos['ano3'] ?? ''), 1, 0, 'C');

        $pdf->Cell($anchoMes, 5.5, $this->encode($datos['mes4'] ?? ''), 1, 0, 'C');
        $pdf->Cell($anchoAno, 5.5, (string)($datos['ano4'] ?? ''), 1, 1, 'C');

        $pdf->Ln(3);

        // 10. AUTORIZADO POR
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(190, 5, 'AUTORIZADO POR', 1, 1, 'C', true);

        $startYAut = $pdf->GetY();

        // Columna Izquierda: Autorizador (Ancho: 65)
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4.5, 'NOMBRES Y APELLIDOS', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(65, 12, $this->encode($datos['nombre_autorizador'] ?? 'CESAR RODRIGUEZ MARIA'), 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4.5, $this->encode('CÉDULA DE IDENTIDAD'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(65, 12, $this->encode($datos['cedula_autorizador'] ?? '8906738'), 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4.5, 'CARGO', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(65, 12, $this->encode($datos['cargo_autorizador'] ?? 'Aprobador Autorizado Cobro Pensión'), 1, 1, 'C');

        // Columna Derecha: Oficina Administrativa (Ancho: 125)
        $pdf->SetXY(75, $startYAut);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(125, 4.5, 'OFICINA ADMINISTRATIVA', 1, 1, 'C');

        $pdf->SetXY(75, $startYAut + 4.5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(125, 45, $this->encode($datos['oficina_autorizador'] ?? 'DIRECCIÓN DE PRESTACIONES'), 1, 1, 'C');

        // 11. Footer Institucional
        $pdf->SetY(248);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(190, 4, 'DDI/08/2013', 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(38, 4, $this->encode('CÓDIGO DE VERIFICACIÓN:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(35, 4, $this->encode($datos['codigo_verificacion'] ?? ''), 0, 0, 'L');
        $pdf->Cell(85, 4, 'PARA SER VALIDADO POR EL BANCO A TRAVES DEL PORTAL ', 0, 0, 'L');
        $pdf->SetFont('Arial', 'U', 7);
        $pdf->Cell(30, 4, 'WWW.IVSS.GOB.VE', 0, 1, 'L');

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(190, 4, 'EL PRESENTE DOCUMENTO CARECE DE VALIDEZ SI PRESENTA ENMIENDAS', 0, 1, 'C');

        return $pdf->Output('S');
    }

    /**
     * Convierte texto UTF-8 a ISO-8859-1 para fuentes nativas de FPDF.
     */
    protected function encode(?string $texto): string
    {
        if ($texto === null || $texto === '') {
            return '';
        }
        return mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
    }
}
