<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('layouts.app')]
#[Title('Auditoría del Sistema')]
class AuditoriaManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filtroEvento = 'todos';
    public string $filtroUsuario = 'todos';
    public string $filtroFecha = '7dias'; // 'hoy', '7dias', '30dias', 'todos'

    public ?int $selectedId = null;
    public ?array $selectedDetail = null;
    public bool $modalDetalleOpen = false;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroEvento()
    {
        $this->resetPage();
    }

    public function updatingFiltroUsuario()
    {
        $this->resetPage();
    }

    public function updatingFiltroFecha()
    {
        $this->resetPage();
    }

    public function verDetalle(int $id)
    {
        $act = Activity::with(['causer', 'subject'])->find($id);
        if ($act) {
            $this->selectedId = $act->id;
            $this->selectedDetail = [
                'id' => $act->id,
                'descripcion' => $act->description,
                'evento' => $act->event,
                'fecha' => $act->created_at->format('d/m/Y H:i:s'),
                'usuario' => $act->causer ? ($act->causer->nombre ?? $act->causer->usuario) : 'Sistema / Anónimo',
                'usuario_login' => $act->causer->usuario ?? 'N/A',
                'subject_type' => class_basename($act->subject_type ?? ''),
                'subject_id' => $act->subject_id,
                'properties' => $act->properties?->toArray() ?? [],
            ];
            $this->modalDetalleOpen = true;
        }
    }

    public function cerrarModal()
    {
        $this->modalDetalleOpen = false;
        $this->selectedId = null;
        $this->selectedDetail = null;
    }

    public function exportarCsv(): StreamedResponse
    {
        abort_if(!auth()->user()->can('sistema.logs'), 403, 'Acceso Denegado');

        $query = $this->getQuery();
        $activities = $query->limit(2000)->get();

        $response = new StreamedResponse(function () use ($activities) {
            $handle = fopen('php://output', 'w');
            // BOM UTF-8 for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($handle, ['ID', 'Fecha y Hora', 'Evento', 'Usuario', 'Nombre', 'Descripción', 'IP', 'Dispositivo', 'Navegador', 'SO', 'URL']);

            foreach ($activities as $act) {
                $props = $act->properties ?? [];
                fputcsv($handle, [
                    $act->id,
                    $act->created_at->format('Y-m-d H:i:s'),
                    strtoupper($act->event ?? 'ACCION'),
                    $act->causer->usuario ?? 'Sistema',
                    $act->causer->nombre ?? 'N/A',
                    $act->description,
                    $props['ip'] ?? 'N/A',
                    $props['dispositivo'] ?? 'N/A',
                    $props['navegador'] ?? 'N/A',
                    $props['sistema_operativo'] ?? 'N/A',
                    $props['url'] ?? 'N/A',
                ]);
            }

            fclose($handle);
        });

        $filename = 'auditoria_ivss_' . date('Ymd_His') . '.csv';
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    protected function getQuery()
    {
        $query = Activity::with('causer')->latest();

        if ($this->filtroEvento !== 'todos') {
            $query->where('event', $this->filtroEvento);
        }

        if ($this->filtroUsuario !== 'todos') {
            $query->where('causer_id', $this->filtroUsuario);
        }

        if ($this->filtroFecha === 'hoy') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($this->filtroFecha === '7dias') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($this->filtroFecha === '30dias') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }

        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('description', 'like', $term)
                  ->orWhere('event', 'like', $term)
                  ->orWhereJsonContains('properties->ip', trim($this->search))
                  ->orWhereHasMorph('causer', [User::class], function ($uq) use ($term) {
                      $uq->where('usuario', 'like', $term)
                         ->orWhere('nombre', 'like', $term);
                  });
            });
        }

        return $query;
    }

    public function render()
    {
        abort_if(!auth()->user()->can('sistema.logs'), 403, 'No tienes permiso para ver la auditoría.');

        $actividades = $this->getQuery()->paginate(15);

        // KPIs
        $totalActividades = Activity::count();
        $iniciosHoy = Activity::where('event', 'login')->whereDate('created_at', Carbon::today())->count();
        $seguridadHoy = Activity::whereIn('event', ['seguridad', 'eliminacion', 'login_fallido'])
            ->whereDate('created_at', Carbon::today())
            ->count();
        $usuariosActivosHoy = Activity::whereNotNull('causer_id')
            ->whereDate('created_at', Carbon::today())
            ->distinct('causer_id')
            ->count('causer_id');

        $usuariosFiltro = User::orderBy('usuario')->get(['id', 'usuario', 'nombre']);

        return view('livewire.admin.auditoria-manager', compact(
            'actividades',
            'totalActividades',
            'iniciosHoy',
            'seguridadHoy',
            'usuariosActivosHoy',
            'usuariosFiltro'
        ));
    }
}

