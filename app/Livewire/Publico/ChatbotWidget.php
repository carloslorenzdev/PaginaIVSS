<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Actions\Publico\Chatbot\ProcesarMensajeChatbotAction;

class ChatbotWidget extends Component
{
    public bool $isOpen = false;
    public array $messages = [];
    public string $inputMessage = '';
    public bool $isThinking = false;

    public function mount()
    {
        $this->resetChat();
    }

    public function resetChat()
    {
        $this->messages = [
            [
                'id' => 'initial-greeting',
                'sender' => 'bot',
                'type' => 'menu',
                'text' => "¡Hola! Bienvenido al portal del Instituto Venezolano de los Seguros Sociales.\n\n¿En qué puedo ayudarte hoy?",
            ]
        ];
        $this->isThinking = false;
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->dispatch('chat-scrolled');
        }
    }

    public function abrirChat()
    {
        $this->isOpen = true;
        $this->dispatch('chat-scrolled');
    }

    public function cerrarChat()
    {
        $this->isOpen = false;
    }

    /**
     * Paso 1: Enviar mensaje de texto. Aparece INMEDIATAMENTE en la pantalla.
     */
    public function enviarMensaje()
    {
        $this->validate([
            'inputMessage' => 'required|string|max:500',
        ]);

        $texto = trim($this->inputMessage);
        $this->inputMessage = '';

        // 1. Mostrar de inmediato el mensaje del usuario
        $this->messages[] = [
            'id' => 'user-' . uniqid(),
            'sender' => 'user',
            'type' => 'text',
            'text' => $texto,
        ];

        // 2. Activar indicador de escritura
        $this->isThinking = true;
        $this->dispatch('chat-scrolled');

        // 3. Despachar procesamiento de respuesta en segundo plano
        $this->dispatch('procesar-respuesta-bot', query: $texto);
    }

    /**
     * Paso 1: Seleccionar opción rápida. Aparece INMEDIATAMENTE en la pantalla.
     */
    public function seleccionarOpcion(string $opcion)
    {
        $etiquetas = [
            'pension' => 'Información pensión.',
            'medicamentos' => 'Medicamentos Alto Costo.',
            'hemodialisis' => 'Hemodiálisis.',
        ];

        $label = $etiquetas[$opcion] ?? $opcion;

        // 1. Mostrar de inmediato el mensaje del usuario
        $this->messages[] = [
            'id' => 'user-' . uniqid(),
            'sender' => 'user',
            'type' => 'text',
            'text' => $label,
        ];

        // 2. Activar indicador de escritura
        $this->isThinking = true;
        $this->dispatch('chat-scrolled');

        // 3. Despachar procesamiento de respuesta en segundo plano
        $this->dispatch('procesar-respuesta-bot', query: $opcion);
    }

    /**
     * Paso 2: Procesar la respuesta del bot de forma asíncrona tras mostrar el mensaje del usuario.
     */
    #[On('procesar-respuesta-bot')]
    public function procesarRespuestaBot(string $query, ?ProcesarMensajeChatbotAction $action = null)
    {
        $action = $action ?? app(ProcesarMensajeChatbotAction::class);
        $respuesta = $action->execute($query);

        $this->messages[] = [
            'id' => 'bot-' . uniqid(),
            'sender' => 'bot',
            'type' => 'answer',
            'text' => $respuesta,
        ];

        $this->isThinking = false;
        $this->dispatch('chat-scrolled');
    }

    public function pedirGps()
    {
        $this->messages[] = [
            'id' => 'user-' . uniqid(),
            'sender' => 'user',
            'type' => 'text',
            'text' => 'Centro de Salud Cercano.',
        ];

        $this->messages[] = [
            'id' => 'bot-' . uniqid(),
            'sender' => 'bot',
            'type' => 'answer',
            'text' => 'Determinando tu ubicación de forma automática...',
        ];

        $this->isThinking = true;
        $this->dispatch('chat-scrolled');
    }

    public function responderErrorGps(string $texto)
    {
        $this->messages[] = [
            'id' => 'bot-' . uniqid(),
            'sender' => 'bot',
            'type' => 'answer',
            'text' => $texto,
        ];

        $this->isThinking = false;
        $this->dispatch('chat-scrolled');
    }

    public function generarRespuesta(string $query, ?ProcesarMensajeChatbotAction $action = null)
    {
        $action = $action ?? app(ProcesarMensajeChatbotAction::class);
        $respuesta = $action->execute($query);

        $this->messages[] = [
            'id' => 'bot-' . uniqid(),
            'sender' => 'bot',
            'type' => 'answer',
            'text' => $respuesta,
        ];

        $this->isThinking = false;
        $this->dispatch('chat-scrolled');
    }

    public function reiniciar()
    {
        $this->resetChat();
        $this->dispatch('chat-scrolled');
    }

    public function render()
    {
        return view('livewire.publico.chatbot-widget');
    }
}
