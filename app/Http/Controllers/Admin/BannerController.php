<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('banners.ver')) {
            abort(403, 'No tienes permiso para ver Banners y Alertas.');
        }

        $banners = Banner::latest()->get();
        
        $alertaImg = Configuracion::where('clave', 'alerta_emergente_img')->value('valor');
        $alertaEnlace = Configuracion::where('clave', 'alerta_emergente_url')->value('valor');
        $alertaTitulo = Configuracion::where('clave', 'alerta_emergente_titulo')->value('valor');

        return view('admin.banners.index', compact('banners', 'alertaImg', 'alertaEnlace', 'alertaTitulo'));
    }

    // --- ALERTA EMERGENTE ---
    public function updateAlerta(Request $request)
    {
        if (!auth()->user()->can('banners.editar')) {
            abort(403, 'No tienes permiso para editar Banners y Alertas.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'archivo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'enlace' => 'nullable|url|max:255',
        ]);

        $ruta_imagen = $request->file('archivo')->store('banners', 'public');

        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_img'], ['valor' => $ruta_imagen]);
        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_url'], ['valor' => $request->enlace]);
        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_titulo'], ['valor' => $request->titulo]);

        return redirect()->route('admin.banners.index')->with('success', 'Alerta Emergente actualizada exitosamente.');
    }

    public function clearAlerta()
    {
        if (!auth()->user()->can('banners.eliminar')) {
            abort(403, 'No tienes permiso para eliminar Banners y Alertas.');
        }

        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_img'], ['valor' => null]);
        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_url'], ['valor' => null]);
        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_titulo'], ['valor' => null]);

        return redirect()->route('admin.banners.index')->with('success', 'Alerta Emergente removida exitosamente.');
    }

    // --- CARRUSEL DE PROMOCIONES ---
    public function store(Request $request)
    {
        if (!auth()->user()->can('banners.crear')) {
            abort(403, 'No tienes permiso para crear Banners y Alertas.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'archivo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'enlace' => 'nullable|url|max:255',
        ]);

        $ruta_imagen = $request->file('archivo')->store('banners', 'public');

        Banner::create([
            'titulo' => $request->titulo,
            'ruta_imagen' => $ruta_imagen,
            'enlace' => $request->enlace,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Imagen añadida al Carrusel de Promociones exitosamente.');
    }

    public function destroy(Banner $banner)
    {
        if (!auth()->user()->can('banners.eliminar')) {
            abort(403, 'No tienes permiso para eliminar Banners y Alertas.');
        }

        if ($banner->ruta_imagen && Storage::disk('public')->exists($banner->ruta_imagen)) {
            Storage::disk('public')->delete($banner->ruta_imagen);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Imagen del carrusel eliminada exitosamente.');
    }
}
