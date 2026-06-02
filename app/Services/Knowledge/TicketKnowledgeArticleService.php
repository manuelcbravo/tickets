<?php

namespace App\Services\Knowledge;

use App\Models\KnowledgeArticle;
use App\Models\Ticket;
use App\Models\TicketKnowledgeArticle;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TicketKnowledgeArticleService
{
    public function link(Ticket $ticket, KnowledgeArticle $article, array $data, int $usuarioId): TicketKnowledgeArticle
    {
        return DB::transaction(function () use ($ticket, $article, $data, $usuarioId): TicketKnowledgeArticle {
            try {
                $link = TicketKnowledgeArticle::query()->create([
                    'ticket_id' => $ticket->id,
                    'knowledge_article_id' => $article->id,
                    'tipo_relacion' => $data['tipo_relacion'] ?? 'relacionado',
                    'notas' => $data['notas'] ?? null,
                    'created_by_id' => $usuarioId,
                ]);
            } catch (QueryException) {
                throw ValidationException::withMessages([
                    'knowledge_article_id' => 'Este articulo ya esta relacionado con el ticket usando el mismo tipo de relacion.',
                ]);
            }

            app(TicketHistoryService::class)->log(
                $ticket,
                'knowledge_article_linked',
                $usuarioId,
                descripcion: 'Articulo de conocimiento relacionado.',
                metadata: [
                    'article_id' => $article->id,
                    'article_title' => $article->titulo,
                    'tipo_relacion' => $link->tipo_relacion,
                ],
            );

            return $link;
        });
    }

    public function unlink(Ticket $ticket, KnowledgeArticle $article, int $usuarioId): void
    {
        DB::transaction(function () use ($ticket, $article, $usuarioId): void {
            TicketKnowledgeArticle::query()
                ->where('ticket_id', $ticket->id)
                ->where('knowledge_article_id', $article->id)
                ->delete();

            app(TicketHistoryService::class)->log(
                $ticket,
                'knowledge_article_unlinked',
                $usuarioId,
                descripcion: 'Relacion con articulo de conocimiento eliminada.',
                metadata: [
                    'article_id' => $article->id,
                    'article_title' => $article->titulo,
                ],
            );
        });
    }
}
