<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app-public')]
#[Title('Quiénes Somos - IVSS')]
class QuienesSomos extends Component
{
    public function render()
    {
        return view('livewire.publico.quienes-somos');
    }
}
