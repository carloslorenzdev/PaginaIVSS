<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use App\Models\Medio;

class TestUploadsController extends Controller
{
    public function __invoke()
    {
        $medios = Medio::orderBy('fecha_subida', 'desc')->get();
        return view('test-uploads', compact('medios'));
    }
}
