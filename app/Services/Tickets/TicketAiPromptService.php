<?php

namespace App\Services\Tickets;

class TicketAiPromptService
{
    public function build(array $context, string $analysisType = 'full'): string
    {
        $schema = [
            'summary' => 'Resumen corto del ticket',
            'detected_problem' => 'Problema probable',
            'suggested_classification' => [
                'type' => 'Bug|Soporte|Mantenimiento menor|Mejora funcional|Nuevo desarrollo|Incidente critico|Solicitud comercial',
                'priority' => 'P0 - Critica|P1 - Alta|P2 - Media|P3 - Baja|P4 - Backlog',
                'impact' => 'Bajo|Medio|Alto|Critico',
                'urgency' => 'Baja|Media|Alta|Inmediata',
                'risk' => 'Bajo|Medio|Alto',
                'difficulty' => 'Simple|Media|Compleja',
            ],
            'missing_information' => [
                ['key' => 'captura_video', 'label' => 'Captura o video', 'required' => true, 'reason' => 'Motivo breve'],
            ],
            'suggested_reply' => 'Respuesta profesional sugerida al cliente, sin prometer fechas.',
            'suggested_checklist' => [
                ['title' => 'Validar pasos', 'description' => 'Detalle breve', 'required' => true],
            ],
            'can_answer_directly' => false,
            'requires_code_change' => false,
            'requires_quote' => false,
            'confidence' => 0.82,
            'warnings' => ['Advertencia breve'],
        ];

        return implode("\n", [
            'Eres un asistente interno para clasificar tickets de una empresa de desarrollo de software.',
            'Tipo de analisis solicitado: '.$analysisType.'.',
            'Responde solo JSON valido, sin markdown, sin texto fuera del JSON.',
            'Usa exactamente una estructura compatible con este ejemplo: '.json_encode($schema, JSON_UNESCAPED_UNICODE),
            'Reglas de seguridad obligatorias:',
            '- No cierres tickets ni sugieras cambiar estado a Cerrado.',
            '- No respondas automaticamente al cliente; solo redacta un borrador.',
            '- No prometas fechas de entrega.',
            '- No ejecutes codigo, despliegues ni acciones de produccion.',
            '- No decidas cobros; solo puedes sugerir requires_quote.',
            '- Usa solo el ticket actual y articulos de conocimiento incluidos.',
            '- Si no hay informacion suficiente, declara faltantes requeridos.',
            'Contexto JSON:',
            json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        ]);
    }
}
