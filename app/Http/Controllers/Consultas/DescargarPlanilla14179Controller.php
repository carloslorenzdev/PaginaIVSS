<?php

namespace App\Http\Controllers\Consultas;

use App\Actions\Consultas\ConsultarAutorizacionCobroAction;
use App\Actions\Consultas\GenerarPlanilla14179PdfAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DescargarPlanilla14179Controller extends Controller
{
    public function __invoke(
        Request $request, 
        string $id,
        ConsultarAutorizacionCobroAction $consultarAction,
        GenerarPlanilla14179PdfAction $pdfAction
    ) {
        $idLimpio = strtoupper(trim(preg_replace('/[^A-Za-z0-9]/', '', $id)));

        if (empty($idLimpio)) {
            abort(400, 'Número de planilla inválido.');
        }

        $datos = $consultarAction->consultarPorPlanilla($idLimpio);

        if (!$datos) {
            abort(404, 'La planilla solicitada no fue encontrada.');
        }

        $pdfBytes = $pdfAction->execute($datos);
        $fileName = 'forma_14_179_' . $idLimpio . '.pdf';

        return response($pdfBytes, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
