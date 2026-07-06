<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotPreguntaSinRespuesta extends Model
{
    use HasFactory;
    
    protected $table = 'chatbot_preguntas_sin_respuesta';
    
    protected $fillable = ['pregunta'];
}
