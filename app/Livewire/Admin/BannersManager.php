<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Banner;
use App\Models\Configuracion;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Banners y Alertas')]
class BannersManager extends Component
{
    use WithFileUploads;

    // Alerta Emergente
    public ?string $alertaImg = null;
    public ?string $alertaEnlace = null;
    public ?string $alertaTitulo = null;
    public string $nuevoAlertaTitulo = '';
    public string $nuevoAlertaEnlace = '';
    public $nuevoAlertaArchivo = null;

    // Carrusel de Banners
    public string $bannerTitulo = '';
    public string $bannerEnlace = '';
    public $bannerArchivo = null;

    // Modal Eliminar Banner
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingTitulo = '';

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->alertaImg = Configuracion::where('clave', 'alerta_emergente_img')->value('valor');
        $this->alertaEnlace = Configuracion::where('clave', 'alerta_emergente_url')->value('valor');
        $this->alertaTitulo = Configuracion::where('clave', 'alerta_emergente_titulo')->value('valor');
        $this->nuevoAlertaTitulo = $this->alertaTitulo ?? '';
        $this->nuevoAlertaEnlace = $this->alertaEnlace ?? '';
    }

    public function guardarAlerta()
    {
        abort_if(!auth()->user()->can('banners.editar'), 403, 'No tienes permiso para editar Banners y Alertas.');

        $rules = [
            'nuevoAlertaTitulo' => 'required|string|max:255',
            'nuevoAlertaEnlace' => 'nullable|url|max:255',
            'nuevoAlertaArchivo' => $this->alertaImg ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120' : 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];

        $messages = [
            'nuevoAlertaTitulo.required' => 'El título de la alerta es obligatorio.',
            'nuevoAlertaArchivo.required' => 'Debe seleccionar una imagen para la alerta emergente.',
            'nuevoAlertaArchivo.image' => 'El archivo debe ser una imagen válida (jpg, png, webp).',
            'nuevoAlertaArchivo.max' => 'La imagen no debe superar los 5MB.',
        ];

        $this->validate($rules, $messages);

        if ($this->nuevoAlertaArchivo) {
            $opt = ImageOptimizerService::optimizarYGuardar(
                $this->nuevoAlertaArchivo,
                'banners',
                'alerta-' . time(),
                ImageOptimizerService::MAX_WIDTH_BANNER,
                ImageOptimizerService::CALIDAD_WEBP,
                'public'
            );
            Configuracion::updateOrCreate(['clave' => 'alerta_emergente_img'], ['valor' => $opt['ruta']]);
        }

        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_url'], ['valor' => $this->nuevoAlertaEnlace ?: null]);
        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_titulo'], ['valor' => $this->nuevoAlertaTitulo]);

        $this->nuevoAlertaArchivo = null;
        $this->loadData();
        session()->flash('success', 'Alerta Emergente actualizada exitosamente.');
    }

    public function limpiarAlerta()
    {
        abort_if(!auth()->user()->can('banners.eliminar'), 403, 'No tienes permiso para eliminar Banners y Alertas.');

        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_img'], ['valor' => null]);
        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_url'], ['valor' => null]);
        Configuracion::updateOrCreate(['clave' => 'alerta_emergente_titulo'], ['valor' => null]);

        $this->loadData();
        session()->flash('success', 'Alerta Emergente removida exitosamente.');
    }

    public function guardarBanner()
    {
        abort_if(!auth()->user()->can('banners.crear'), 403, 'No tienes permiso para crear Banners y Alertas.');

        $this->validate([
            'bannerTitulo' => 'required|string|max:255',
            'bannerEnlace' => 'nullable|url|max:255',
            'bannerArchivo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'bannerTitulo.required' => 'El título del banner es obligatorio.',
            'bannerArchivo.required' => 'Debe adjuntar una imagen para el banner.',
            'bannerArchivo.image' => 'El archivo debe ser una imagen (jpg, png, webp).',
            'bannerArchivo.max' => 'La imagen no debe exceder los 5MB.',
        ]);

        $opt = ImageOptimizerService::optimizarYGuardar(
            $this->bannerArchivo,
            'banners',
            'banner-' . time(),
            ImageOptimizerService::MAX_WIDTH_BANNER,
            ImageOptimizerService::CALIDAD_WEBP,
            'public'
        );

        Banner::create([
            'titulo' => $this->bannerTitulo,
            'ruta_imagen' => $opt['ruta'],
            'enlace' => $this->bannerEnlace ?: null,
        ]);

        $this->bannerTitulo = '';
        $this->bannerEnlace = '';
        $this->bannerArchivo = null;
        session()->flash('success', 'Banner añadido al carrusel de promociones exitosamente.');
    }

    public function confirmDeleteBanner(int $id)
    {
        abort_if(!auth()->user()->can('banners.eliminar'), 403, 'No tienes permiso para eliminar Banners y Alertas.');
        $banner = Banner::findOrFail($id);
        $this->deletingId = $banner->id;
        $this->deletingTitulo = $banner->titulo;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingTitulo = '';
        $this->dispatch('close-modal');
    }

    public function deleteBanner()
    {
        abort_if(!auth()->user()->can('banners.eliminar'), 403, 'No tienes permiso para eliminar Banners y Alertas.');
        if ($this->deletingId) {
            $banner = Banner::findOrFail($this->deletingId);
            if ($banner->ruta_imagen && Storage::disk('public')->exists($banner->ruta_imagen)) {
                Storage::disk('public')->delete($banner->ruta_imagen);
            }
            $banner->delete();
            session()->flash('success', 'Imagen del carrusel eliminada exitosamente.');
        }
        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->can('banners.ver'), 403, 'No tienes permiso para ver Banners y Alertas.');

        $banners = Banner::latest()->get();

        return view('livewire.admin.banners-manager', [
            'banners' => $banners,
        ]);
    }
}
