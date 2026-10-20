<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Directorio;
use App\Models\Estado;
use Illuminate\Support\Str;

#[Layout('layouts.app-public')]
class DirectorioSearch extends Component
{
    public string $tipo = 'centro_salud';
    public string $titulo = 'Centros de Salud IVSS';
    public string $subtitulo = 'Hospitales y Ambulatorios del IVSS ubicados en su región.';
    public string $icono = 'fas fa-hospital';
    public string $heroBg = 'img/medical-aesthetic-2.png';
    public string $search = '';

    public function mount(string $tipo = 'centro_salud', ?string $titulo = null, ?string $subtitulo = null, ?string $icono = null, ?string $heroBg = null)
    {
        $this->tipo = $tipo;

        if ($tipo === 'farmacia') {
            $this->titulo = $titulo ?? 'Farmacias de Alto Costo IVSS';
            $this->subtitulo = $subtitulo ?? 'Seleccione en la siguiente lista para obtener información sobre las Farmacias IVSS ubicadas en su región.';
            $this->icono = $icono ?? 'fas fa-clinic-medical';
            $this->heroBg = $heroBg ?? 'img/medical-aesthetic-1.png';
        } elseif ($tipo === 'oficina_administrativa') {
            $this->titulo = $titulo ?? 'Oficinas Administrativas IVSS';
            $this->subtitulo = $subtitulo ?? 'Seleccione en la siguiente lista para obtener información sobre las Oficinas Administrativas ubicadas en su región.';
            $this->icono = $icono ?? 'fas fa-building';
            $this->heroBg = $heroBg ?? 'img/medical-aesthetic-2.png';
        } else {
            $this->titulo = $titulo ?? 'Centros de Salud IVSS';
            $this->subtitulo = $subtitulo ?? 'Seleccione en la siguiente lista para obtener información sobre los Hospitales y Ambulatorios del IVSS ubicados en su región.';
            $this->icono = $icono ?? 'fas fa-hospital';
            $this->heroBg = $heroBg ?? 'img/medical-aesthetic-2.png';
        }
    }

    public function getEstadosProperty()
    {
        $allEstados = Estado::where('idpaisfk', 1)
            ->orderBy('estado')
            ->pluck('estado')
            ->map(fn($e) => mb_convert_case($e, MB_CASE_TITLE, 'UTF-8'))
            ->toArray();

        // Agrupar todos los directorios del tipo actual por clave normalizada de estado
        $directoriosPorEstado = Directorio::where('tipo', $this->tipo)
            ->with(['municipioRelacion', 'parroquiaRelacion'])
            ->get()
            ->groupBy(function ($item) {
                return Str::ascii(strtolower(trim($item->estado)));
            });

        $query = Str::ascii(Str::lower(trim($this->search)));

        return collect($allEstados)->filter(function ($estado) use ($query) {
            if (empty($query)) return true;
            $normalizedEstado = Str::ascii(Str::lower($estado));
            return Str::contains($normalizedEstado, $query);
        })->map(function ($estado) use ($directoriosPorEstado) {
            $key = Str::ascii(strtolower(trim($estado)));
            $items = $directoriosPorEstado->get($key, collect())->values();

            return [
                'nombre' => $estado,
                'total' => $items->count(),
                'instalaciones' => $items->map(function ($inst) {
                    return [
                        'id' => $inst->id,
                        'nombre' => $inst->nombre,
                        'direccion' => $inst->direccion ?: 'Información no disponible',
                        'telefono' => $inst->telefono ?: 'Información no disponible',
                        'municipio' => $inst->municipio ?: ($inst->municipioRelacion?->municipio ?? ''),
                        'parroquia' => $inst->parroquia ?: ($inst->parroquiaRelacion?->parroquia ?? ''),
                    ];
                })->all(),
            ];
        })->values();
    }

    public function render()
    {
        $map = [];
        foreach ($this->estados as $est) {
            $map[$est['nombre']] = $est['instalaciones'];
        }

        return view('livewire.directorio-search', [
            'estados' => $this->estados,
            'instalacionesMap' => $map,
        ]);
    }
}

