<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Actions\Publico\ObtenerTodasLasNoticiasAction;

#[Layout('layouts.app-public')]
#[Title('Noticias')]
class NoticiasSearch extends Component
{
    use WithPagination;

    public string $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render(ObtenerTodasLasNoticiasAction $action)
    {
        $noticias = $action->execute($this->search);

        return view('livewire.noticias-search', [
            'noticias' => $noticias,
        ]);
    }
}
