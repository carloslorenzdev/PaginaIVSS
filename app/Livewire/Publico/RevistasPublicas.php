<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Revista;

#[Layout('layouts.app-public')]
#[Title('Revista Digital - IVSS')]
class RevistasPublicas extends Component
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
        $query = Revista::where('publicado', true);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('titulo', 'like', '%' . $this->search . '%')
                  ->orWhere('edicion', 'like', '%' . $this->search . '%');
            });
        }

        $revistas = $query->orderBy('fecha_publicacion', 'desc')->paginate(12);

        return view('livewire.publico.revistas', compact('revistas'));
    }
}
