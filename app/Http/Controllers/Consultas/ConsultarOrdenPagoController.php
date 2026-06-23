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
            return response($result['body'], 200)
                ->header('Content-Type', $result['contentType'])
                ->header('Content-Disposition', 'attachment; filename="Orden_de_Pago_'.$request->periodo.'.pdf"');
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }
}
