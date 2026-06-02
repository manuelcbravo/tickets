<?php

namespace App\Services\Knowledge;

use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KnowledgeFromTicketService
{
    public function create(Ticket $ticket, array $data, int $usuarioId): \App\Models\KnowledgeArticle
    {
        if (! $ticket->closed_at && ! $ticket->resuelto_at && blank($ticket->resolution)) {
            throw ValidationException::withMessages([
                'ticket' => 'Solo se puede crear documentacion desde un ticket cerrado o resuelto.',
            ]);
        }

        return DB::transaction(function () use ($ticket, $data, $usuarioId) {
            $article = app(KnowledgeArticleService::class)->create([
                ...$data,
                'fuente_ticket_id' => $ticket->id,
                'cliente_id' => $data['cliente_id'] ?? $ticket->cliente_id,
                'proyecto_id' => $data['proyecto_id'] ?? $ticket->proyecto_id,
                'proyecto_modulo_id' => $data['proyecto_modulo_id'] ?? $ticket->proyecto_modulo_id,
            ], $usuarioId);

            app(TicketKnowledgeArticleService::class)->link($ticket, $article, [
                'tipo_relacion' => 'creado_desde_ticket',
                'notas' => 'Articulo creado desde el ticket.',
            ], $usuarioId);

            app(TicketHistoryService::class)->log(
                $ticket,
                'knowledge_article_created_from_ticket',
                $usuarioId,
                descripcion: 'Articulo creado desde ticket.',
                metadata: [
                    'article_id' => $article->id,
                    'article_title' => $article->titulo,
                ],
            );

            return $article;
        });
    }

    public function defaults(Ticket $ticket): array
    {
        $ticket->loadMissing(['cliente', 'proyecto', 'modulo']);

        return [
            'titulo' => "{$ticket->folio} - {$ticket->titulo}",
            'resumen' => $ticket->resolution ?: $ticket->descripcion,
            'contenido' => implode("\n\n", [
                "## Problema reportado\n{$ticket->descripcion}",
                '## Contexto del cliente/proyecto',
                'Cliente: '.($ticket->cliente?->nombre ?? $ticket->cliente?->razon_social ?? 'Sin cliente'),
                'Proyecto: '.($ticket->proyecto?->nombre ?? 'Sin proyecto'),
                'Modulo: '.($ticket->modulo?->nombre ?? 'Sin modulo'),
                "## Solucion aplicada\n".($ticket->resolution ?: 'Pendiente de documentar.'),
                "## Evidencia o notas\nRevisar comentarios, adjuntos e historial del ticket {$ticket->folio}.",
                "## Pasos recomendados\n1. Confirmar contexto.\n2. Aplicar solucion documentada.\n3. Validar con evidencia.",
            ]),
            'tipo' => 'solucion_error',
            'visibilidad' => 'interna',
            'estatus' => 'borrador',
            'cliente_id' => $ticket->cliente_id,
            'proyecto_id' => $ticket->proyecto_id,
            'proyecto_modulo_id' => $ticket->proyecto_modulo_id,
            'fuente_ticket_id' => $ticket->id,
        ];
    }
}
