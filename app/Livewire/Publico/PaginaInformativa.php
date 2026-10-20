<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app-public')]
class PaginaInformativa extends Component
{
    public string $seccion;
    public string $titulo;

    public function mount(string $seccion, string $titulo = 'Instituto Venezolano de los Seguros Sociales')
    {
        $this->seccion = $seccion;
        $this->titulo = $titulo;
    }

    public function render()
    {
        return view('livewire.publico.secciones.' . $this->seccion)
            ->title($this->titulo);
    }
}
