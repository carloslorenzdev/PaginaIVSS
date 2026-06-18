<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Configuraciones\ActualizarMembreteAction;

class UpdateMembreteController extends Controller
{
    public function __invoke(Request $request, ActualizarMembreteAction $action)
    {
        if (env('WEB_EDITABLE', false) == false) {
            abort(404);
        }

        $request->validate([
            'membrete_img' => 'required|image|max:10240'
        ]);

        $archivo = $request->file('membrete_img');
        
        $imageSize = getimagesize($archivo->getPathname());
        if ($imageSize) {
            $width = $imageSize[0];
            $height = $imageSize[1];
            
            if ($width < 800 || $height < 100) {
                return back()->withErrors(['membrete_img' => "La imagen no cumple con los estándares de resolución requeridos. Mínimo 800x100 píxeles. (Tu imagen: {$width}x{$height})"]);
            }
        }

        $action->execute($archivo);

        return redirect()->back()->with('success', 'Membrete actualizado correctamente.');
    }
}
