<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Consultas\ConsultarPensionadoAction;

class ConsultarPensionadoController extends Controller
{
    public function __invoke(Request $request, ConsultarPensionadoAction $action)
    {
        $request->validate([
            'nacionalidad' => 'required|in:V,E,T',
            'cedula' => 'required|numeric',
            'd1' => 'required|numeric',
            'm1' => 'required|numeric',
            'y1' => 'required|numeric',
        ]);

        $result = $action->execute($request->only(['nacionalidad', 'cedula', 'd1', 'm1', 'y1']));

        if ($result['success']) {
            return response()->json([
                'success' => true, 
                'isHtml' => $result['isHtml'] ?? false,
                'message' => $result['message'] ?? '',
                'html' => $result['html'] ?? ''
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
