<?php

namespace App\Actions\Publico\Chatbot;

class ProcesarMensajeChatbotAction
{
    public function __construct(
        protected BuscarUbicacionGpsAction $buscarUbicacion,
        protected BuscarFarmaciasChatbotAction $buscarFarmacias,
        protected BuscarCentrosSaludChatbotAction $buscarCentrosSalud,
        protected ConsultarConocimientoChatbotAction $consultarConocimiento
    ) {}

    /**
     * Orquestar el procesamiento del mensaje derivando a la micro-acción especializada
     */
    public function execute(string $mensaje): string
    {
        $mensajeTrim = trim($mensaje);

        // 1. Ubicación automática (GPS o IP)
        if ($this->buscarUbicacion->esConsultaUbicacion($mensajeTrim)) {
            return $this->buscarUbicacion->execute($mensajeTrim);
        }

        // 2. Detección y búsqueda de Farmacias de Alto Costo
        if ($this->buscarFarmacias->esConsultaFarmacia($mensajeTrim)) {
            return $this->buscarFarmacias->execute($mensajeTrim);
        }

        // 3. Detección y búsqueda de Centros de Salud / Hospitales / Hemodiálisis
        if ($this->buscarCentrosSalud->esConsultaCentroSalud($mensajeTrim)) {
            return $this->buscarCentrosSalud->execute($mensajeTrim);
        }

        // 4. Base de Conocimiento institucional dinámica y registro de preguntas sin respuesta
        return $this->consultarConocimiento->execute($mensajeTrim);
    }
}
