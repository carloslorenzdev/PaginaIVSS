<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Revista;

#[Layout('layouts.app-public')]
class RevistaShow extends Component
{
    public Revista $revista;

    public function mount(Revista $revista)
    {
        if (!$revista->publicado) {
            abort(404);
        }
        $this->revista = $revista;
    }

    public function render()
    {
        return view('livewire.publico.revista-show', [
            'revista' => $this->revista,
        ])->title($this->revista->titulo . ' - Revista Digital IVSS');
    }
}
