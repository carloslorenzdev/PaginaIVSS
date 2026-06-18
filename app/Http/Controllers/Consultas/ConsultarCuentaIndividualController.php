<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Consultas\ConsultarCuentaIndividualAction;

class ConsultarCuentaIndividualController extends Controller
{
    public function __invoke(Request $request, ConsultarCuentaIndividualAction $action)
    {
        $nacionalidad = $request->input('nacionalidad', 'V');
        $cedula = $request->input('cedula', '');
        
        if (empty($cedula)) {
            return response()->json(['success' => false, 'message' => 'Cédula vacía.']);
        }

        $result = $action->execute([
            'nacionalidad' => $nacionalidad,
            'cedula' => $cedula
        ]);

        return response()->json($result);
    }
}
