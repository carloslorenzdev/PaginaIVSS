<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotConocimiento extends Model
{
    use HasFactory;

    protected $table = 'chatbot_conocimientos';

    protected $fillable = [
        'pregunta',
        'palabras_clave',
        'respuesta',
        'activo',
    ];

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
