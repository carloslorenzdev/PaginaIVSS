<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentoInstitucional extends Model
{
    use HasFactory;

    protected $table = 'documentos_institucionales';

    protected $fillable = [
        'seccion',
        'categoria',
        'titulo',
        'descripcion',
        'archivo_path',
        'archivo_nombre_original',
        'formato',
        'tamano_bytes',
        'orden',
        'activo',
        'descargas',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'tamano_bytes' => 'integer',
        'descargas' => 'integer',
    ];

    // Constantes de secciones estándar
    public const SECCION_MARCO_NORMATIVO = 'marco_normativo';
    public const SECCION_CONTRATACIONES = 'contrataciones_publicas';
    public const SECCION_BIBLIOTECA_FORMAS = 'biblioteca_formas';

    public static function seccionesDisponibles(): array
    {
        return [
            self::SECCION_MARCO_NORMATIVO => 'Marco Normativo',
            self::SECCION_CONTRATACIONES => 'Contrataciones Públicas',
            self::SECCION_BIBLIOTECA_FORMAS => 'Biblioteca de Formas',
        ];
    }

    // Categorías predeterminadas por sección
    public static function categoriasPorSeccion(string $seccion): array
    {
        return match ($seccion) {
            self::SECCION_MARCO_NORMATIVO => [
                'Decretos',
                'Ley de Contrataciones',
                'Leyes Especiales',
                'Leyes Orgánicas',
                'Providencias',
                'Reglamentos',
            ],
            self::SECCION_CONTRATACIONES => [
                'Concursos',
                'Adjudicaciones',
                'Compromiso de Responsabilidad Social',
                'Requisitos',
            ],
            self::SECCION_BIBLIOTECA_FORMAS => [
                'Formas',
                'Instructivo de Formas',
            ],
            default => [],
        };
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorSeccion($query, string $seccion)
    {
        return $query->where('seccion', $seccion);
    }

    public function scopePorCategoria($query, string $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    // Accessors
    public function getUrlAttribute(): ?string
    {
        if (empty($this->archivo_path)) {
            return null;
        }

        // Si es una URL externa (legada)
        if (str_starts_with($this->archivo_path, 'http://') || str_starts_with($this->archivo_path, 'https://')) {
            return $this->archivo_path;
        }

        // Si está en storage público
        return asset('storage/' . ltrim($this->archivo_path, '/'));
    }

    public function getTieneArchivoAttribute(): bool
    {
        if (empty($this->archivo_path)) {
            return false;
        }

        if (str_starts_with($this->archivo_path, 'http://') || str_starts_with($this->archivo_path, 'https://')) {
            return true;
        }

        return Storage::disk('public')->exists($this->archivo_path);
    }

    public function getTamanoFormateadoAttribute(): string
    {
        $bytes = $this->tamano_bytes ?? 0;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        } elseif ($bytes > 0) {
            return $bytes . ' B';
        }
        return 'N/D';
    }

    public function getIconoFormatoAttribute(): string
    {
        $fmt = strtolower($this->formato ?? 'pdf');
        return match ($fmt) {
            'pdf' => 'fas fa-file-pdf text-danger',
            'doc', 'docx' => 'fas fa-file-word text-primary',
            'xls', 'xlsx' => 'fas fa-file-excel text-success',
            'zip', 'rar' => 'fas fa-file-archive text-warning',
            default => 'fas fa-file text-secondary',
        };
    }

    public function getEsRecienteAttribute(): bool
    {
        if (!$this->updated_at) {
            return false;
        }
        return $this->updated_at->diffInDays(now()) <= 30;
    }
}
