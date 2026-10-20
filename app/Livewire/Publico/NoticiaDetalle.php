<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Noticia;
use App\Actions\Publico\ObtenerNoticiaPorSlugAction;

#[Layout('layouts.app-public')]
class NoticiaDetalle extends Component
{
    public string $slug;

    public function mount(string $slug)
    {
        $this->slug = $slug;
    }

    public function render(ObtenerNoticiaPorSlugAction $action)
    {
        $noticia = $action->execute($this->slug);

        return view('livewire.publico.noticia-detalle', [
            'noticia' => $noticia,
        ])->title($noticia->titulo . ' - Prensa IVSS');
    }
}
