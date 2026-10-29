<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Consultas\ConsultarOrdenPagoAction;

class ConsultarOrdenPagoController extends Controller
{
    public function __invoke(Request $request, ConsultarOrdenPagoAction $action)
    {
        $request->validate([
            'idEmpresa' => 'required|string',
            'periodo' => 'required|string',
            'tipoEmpresa' => 'required|string',
        ]);

        $result = $action->execute($request->only(['idEmpresa', 'periodo', 'tipoEmpresa']));

        if ($result['success']) {
            $nombreArchivo = 'FacturaIVSS_Periodo' . str_replace('/', '-', $request->periodo) . '.pdf';
            return response($result['body'], 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $nombreArchivo . '"');
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }
}
