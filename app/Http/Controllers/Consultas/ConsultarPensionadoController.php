<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Consultas\ConsultarPensionadoAction;
use App\Actions\Consultas\ConsultarPensionadoNativoAction;

class ConsultarPensionadoController extends Controller
{
    public function __invoke(Request $request, ConsultarPensionadoAction $action, ConsultarPensionadoNativoAction $nativoAction)
    {
        $request->validate([
            'nacionalidad' => 'required|in:V,E,T',
            'cedula' => 'required|numeric',
            'd1' => 'nullable|numeric',
            'm1' => 'nullable|numeric',
            'y1' => 'nullable|numeric',
        ]);

        if ($request->filled('d1') && $request->filled('m1') && $request->filled('y1')) {
            $result = $action->execute($request->only(['nacionalidad', 'cedula', 'd1', 'm1', 'y1']));
        } else {
            $result = $nativoAction->execute($request->only(['nacionalidad', 'cedula']));
        }

        if ($result['success'] ?? false) {
            return response()->json([
                'success' => true, 
                'isHtml' => $result['isHtml'] ?? false,
                'message' => $result['message'] ?? '',
                'html' => $result['html'] ?? '',
                'data' => $result['data'] ?? null
            ]);
        } else {
            return response()->json([
                'success' => false, 
                'isHtml' => false,
                'message' => $result['message'] ?? 'Error desconocido'
            ]);
        }
    }
}
