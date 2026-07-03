<?php

namespace App\Actions\Publico\Chatbot;

use App\Models\Directorio;

class ProcesarMensajeChatbotAction
{
    public function execute(string $mensaje): string
    {
        $mensajeOriginal = $mensaje;
        $mensaje = strtolower($mensaje);
        
        // Quitar acentos rudimentario para simplificar busqueda
        $mensaje = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ä', 'ë', 'ï', 'ö', 'ü'],
            ['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u'],
            $mensaje
        );

        // 1. Detección de Farmacias / Centros de Salud en Base de Datos
        if (str_contains($mensaje, 'farmacia') || str_contains($mensaje, 'alto costo') || str_contains($mensaje, 'medicamento')) {
            $query = Directorio::farmacias();
            
            // Extraer posible ubicación
            $estados = ['caracas', 'miranda', 'zulia', 'aragua', 'carabobo', 'lara', 'tachira', 'merida'];
            $estadoDetectado = null;
            foreach($estados as $estado) {
                if(str_contains($mensaje, $estado)) {
                    $estadoDetectado = ucfirst($estado);
                    if ($estadoDetectado == 'Caracas') $estadoDetectado = 'Distrito Capital';
                    $query->where(function($q) use ($estadoDetectado, $estado) {
                        $q->where('estado', 'LIKE', "%$estadoDetectado%")
                          ->orWhere('direccion', 'LIKE', "%$estado%");
                    });
                }
            }

            $farmacias = $query->take(3)->get();
            
            if ($farmacias->count() > 0) {
                $html = "<b>Farmacias de Alto Costo encontradas en nuestra Base de Datos:</b><br><br>";
                foreach ($farmacias as $f) {
                    $html .= "🏥 <b>{$f->nombre}</b><br>";
                    $html .= "📍 {$f->direccion} ({$f->estado})<br>";
                    if ($f->telefono) $html .= "📞 {$f->telefono}<br>";
                    $html .= "<br>";
                }
                return $html;
            } else {
                return "Lo siento, no encontré farmacias de alto costo específicas para esa ubicación en nuestra base de datos interna. Puedes comunicarte al 0800-IVSS para mayor información.";
            }
        }

        // 2. Detección de Centros de Salud en Base de Datos
        if (str_contains($mensaje, 'hospital') || str_contains($mensaje, 'clinica') || str_contains($mensaje, 'ambulatorio') || str_contains($mensaje, 'centro de salud') || str_contains($mensaje, 'emergencia')) {
            $query = Directorio::centrosSalud();
            
            // Extraer posible ubicación
            $estados = ['caracas', 'miranda', 'zulia', 'aragua', 'carabobo', 'lara', 'tachira', 'merida'];
            foreach($estados as $estado) {
                if(str_contains($mensaje, $estado)) {
                    $estadoDetectado = ucfirst($estado);
                    if ($estadoDetectado == 'Caracas') $estadoDetectado = 'Distrito Capital';
                    $query->where(function($q) use ($estadoDetectado, $estado) {
                        $q->where('estado', 'LIKE', "%$estadoDetectado%")
                          ->orWhere('direccion', 'LIKE', "%$estado%");
                    });
                }
            }

            $centros = $query->take(3)->get();
            
            if ($centros->count() > 0) {
                $html = "<b>Centros de Salud encontrados en nuestra Base de Datos:</b><br><br>";
                foreach ($centros as $c) {
                    $html .= "🏥 <b>{$c->nombre}</b><br>";
                    $html .= "📍 {$c->direccion} ({$c->estado})<br><br>";
                }
                return $html;
            } else {
                return "Lo siento, no tengo centros de salud registrados en el sistema para esa ubicación exacta.";
            }
        }

        // 3. Sistema Tiuna
        if ($this->contieneAlguna($mensaje, ['tiuna', 'empresa', 'patrono', 'registrar', 'nomina', 'trabajador', 'empleador'])) {
            return '<b>Sistema Tiuna (Registro de Empresas y Empleadores):</b><br><br>El Sistema Tiuna es la plataforma oficial del IVSS para empleadores. A través de él puedes:<br>- Registrar una nueva empresa<br>- Afiliar nuevos trabajadores<br>- Pagar la factura mensual<br><br>Para continuar, dirígete a la sección <b>"Sistema Tiuna"</b> en el menú de la página principal.';
        }

        // 4. Pensiones
        if ($this->contieneAlguna($mensaje, ['pension', 'vejez', 'jubilado', 'abuelo', 'tercera edad', 'requisitos'])) {
            return '<b>Requisitos para Pensión de Vejez:</b><br><br>1. 60 años (hombres) o 55 años (mujeres).<br>2. Mínimo de 750 semanas cotizadas.<br>3. Presentar: cédula, constancia de trabajo y solvencia.<br><br>Para consultar tu estatus, busca la sección <b>"Pensionados"</b> en el menú de consultas.';
        }

        // 5. Constancias
        if ($this->contieneAlguna($mensaje, ['constancia', 'recibo', 'comprobante', 'imprimir', 'descargar'])) {
            return '<b>Constancias del IVSS:</b><br><br>Puedes generar y descargar constancias electrónicas gratuitas, como Constancia de Pensionado o Cuenta Individual, totalmente válidas legalmente.<br><br>Accede a la sección <b>"Constancias"</b> para generarlas.';
        }

        // 6. Cuenta Individual / Semanas
        if ($this->contieneAlguna($mensaje, ['cuenta', 'individual', 'semana', 'cotizacion', 'cotizadas', 'historial'])) {
            return '<b>Consulta de Cuenta Individual:</b><br><br>Aquí puedes revisar tu historial laboral, semanas cotizadas y salarios declarados. Solo necesitas tu cédula y fecha de nacimiento.<br><br>Dirígete a la sección <b>"Cuenta Individual"</b> para consultarla.';
        }

        // 7. RRHH / Recursos Humanos
        if ($this->contieneAlguna($mensaje, ['rrhh', 'recurso', 'humanos', 'empleado publico', 'trabajador ivss'])) {
            return '<b>Servicios al Funcionario (RRHH):</b><br><br>Si eres trabajador activo o jubilado directo del IVSS, puedes acceder a la sección de Recursos Humanos para gestionar tus solicitudes, recibos de pago y demás beneficios.<br><br>Dirígete al apartado de <b>"Servicios Complementarios"</b> y haz clic en <b>"Servicios al Funcionario"</b> para iniciar sesión en tu portal.';
        }

        // 8. Saludos / Agradecimientos
        if ($this->contieneAlguna($mensaje, ['hola', 'buenos dias', 'buenas tardes', 'saludo'])) {
            return '¡Hola! Qué gusto saludarte. Soy el Asistente del IVSS. Puedo consultar nuestra base de datos de Farmacias, Hospitales, y guiarte por la página. ¿En qué trámite te puedo asesorar el día de hoy?';
        }
        if ($this->contieneAlguna($mensaje, ['gracias', 'excelente'])) {
            return '¡Con todo el gusto! Estamos para servirte.';
        }

        // 9. Fallback estricto
        return 'Lo siento, soy un Asistente Local configurado exclusivamente para trámites y consultar la base de datos del IVSS. No cuento con IA externa ni conexión a Internet abierta para responder a esa solicitud. ¿Te puedo ayudar buscando alguna farmacia, centro de salud, trámite de RRHH o del Sistema Tiuna?';
    }

    private function contieneAlguna(string $texto, array $palabras): bool
    {
        foreach ($palabras as $palabra) {
            if (str_contains($texto, $palabra)) {
                return true;
            }
        }
        return false;
    }
}
