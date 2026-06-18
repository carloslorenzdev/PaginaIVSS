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
            'IdEmpresa' => 'required|string',
            'periodo' => 'required|string',
            'tipoEmpresa' => 'required|string',
        ]);

        $result = $action->execute($request->only(['IdEmpresa', 'periodo', 'tipoEmpresa']));

        if ($result['success']) {
            return response($result['body'], $result['status'])
                ->header('Content-Type', $result['contentType']);
        } else {
            return response($result['message'], 500);
        }
    }
}
