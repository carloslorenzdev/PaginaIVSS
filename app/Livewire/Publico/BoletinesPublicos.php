<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Boletin;

#[Layout('layouts.app-public')]
#[Title('Boletín Informativo - IVSS')]
class BoletinesPublicos extends Component
{
    use WithPagination;

    public string $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Boletin::where('publicado', true);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('titulo', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });
        }

        $boletines = $query->orderBy('fecha_publicacion', 'desc')->paginate(12);

        return view('livewire.publico.boletines', compact('boletines'));
    }
}
