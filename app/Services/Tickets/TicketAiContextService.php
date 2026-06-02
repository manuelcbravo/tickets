<?php

namespace App\Services\Tickets;

use App\Models\KnowledgeArticle;
use App\Models\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TicketAiContextService
{
    public function build(Ticket $ticket, array $options = []): array
    {
        $ticket->loadMissing([
            'cliente:id,nombre,razon_social,estatus',
            'proyecto:id,nombre,client_id',
            'modulo:id,nombre,project_id',
            'contacto:id,nombre,email',
            'ambiente:id,nombre,url',
            'responsable:id,name',
            'tipo:id,nombre',
            'estado:id,nombre',
            'prioridad:id,nombre',
            'impacto:id,nombre',
            'urgencia:id,nombre',
            'riesgo:id,nombre',
            'adjuntos:id,ticket_id,nombre_original,mime_type,size',
            'knowledgeArticles:id,titulo,resumen,contenido,tipo,visibilidad,estatus,cliente_id,proyecto_id,proyecto_modulo_id',
        ]);

        $comments = collect();
        if ($options['include_comments'] ?? true) {
            $comments = $ticket->mensajes()
                ->with('usuario:id,name')
                ->latest()
                ->limit((int) config('ai.max_ticket_comments', 8))
                ->get()
                ->reverse()
                ->values();
        }

        $articles = ($options['include_knowledge'] ?? true)
            ? $this->knowledgeArticles($ticket)
            : collect();

        return [
            'ticket' => [
                'id' => $ticket->id,
                'folio' => $ticket->folio,
                'titulo' => $ticket->titulo,
                'descripcion' => $ticket->descripcion,
                'estado' => $ticket->estado?->nombre,
                'tipo' => $ticket->tipo?->nombre,
                'prioridad' => $ticket->prioridad?->nombre,
                'impacto' => $ticket->impacto?->nombre,
                'urgencia' => $ticket->urgencia?->nombre,
                'riesgo' => $ticket->riesgo?->nombre,
                'dificultad' => $ticket->dificultad,
                'requires_code_change' => $ticket->requires_code_change,
                'requires_quote' => $ticket->requires_quote,
                'cliente' => $ticket->cliente?->only(['id', 'nombre', 'razon_social', 'estatus']),
                'proyecto' => $ticket->proyecto?->only(['id', 'nombre']),
                'modulo' => $ticket->modulo?->only(['id', 'nombre']),
                'ambiente' => $ticket->ambiente?->only(['id', 'nombre', 'url']),
                'contacto' => $ticket->contacto?->only(['id', 'nombre', 'email']),
                'responsable' => $ticket->responsable?->only(['id', 'name']),
                'created_at' => $ticket->created_at?->toDateTimeString(),
            ],
            'comments' => $comments->map(fn ($message) => [
                'usuario' => $message->usuario?->name,
                'mensaje' => Str::limit($message->mensaje, 1200),
                'es_interno' => $message->es_interno,
                'es_respuesta_cliente' => $message->es_respuesta_cliente,
                'created_at' => $message->created_at?->toDateTimeString(),
            ])->all(),
            'attachments' => $ticket->adjuntos->map(fn ($attachment) => [
                'nombre_original' => $attachment->nombre_original,
                'mime_type' => $attachment->mime_type,
                'size' => $attachment->size,
            ])->all(),
            'knowledge_articles' => $articles->map(fn (KnowledgeArticle $article) => [
                'id' => $article->id,
                'titulo' => $article->titulo,
                'resumen' => $article->resumen,
                'tipo' => $article->tipo,
                'visibilidad' => $article->visibilidad,
                'contenido' => Str::limit(strip_tags($article->contenido), 1600),
            ])->all(),
            'used_knowledge_article_ids' => $articles->pluck('id')->values()->all(),
        ];
    }

    private function knowledgeArticles(Ticket $ticket): Collection
    {
        $limit = (int) config('ai.max_context_articles', 5);
        $direct = $ticket->knowledgeArticles()
            ->whereIn('estatus', ['publicado', 'en_revision'])
            ->limit($limit)
            ->get();

        if ($direct->count() >= $limit) {
            return $direct->take($limit)->values();
        }

        $term = trim($ticket->titulo.' '.$ticket->descripcion);
        $words = collect(preg_split('/\s+/', Str::lower(Str::ascii($term))) ?: [])
            ->filter(fn (string $word) => mb_strlen($word) >= 4)
            ->unique()
            ->take(4)
            ->values();

        $query = KnowledgeArticle::query()
            ->whereIn('estatus', ['publicado', 'en_revision'])
            ->whereNotIn('id', $direct->pluck('id'))
            ->where(function ($scope) use ($ticket): void {
                $scope->whereNull('cliente_id')->orWhere('cliente_id', $ticket->cliente_id);
            })
            ->where(function ($scope) use ($ticket): void {
                $scope->whereNull('proyecto_id')->orWhere('proyecto_id', $ticket->proyecto_id);
            })
            ->where(function ($scope) use ($ticket): void {
                $scope->whereNull('proyecto_modulo_id')->orWhere('proyecto_modulo_id', $ticket->proyecto_modulo_id);
            });

        if ($words->isNotEmpty()) {
            $query->where(function ($scope) use ($words): void {
                foreach ($words as $word) {
                    $scope->orWhere('titulo', 'ilike', "%{$word}%")
                        ->orWhere('resumen', 'ilike', "%{$word}%")
                        ->orWhere('contenido', 'ilike', "%{$word}%");
                }
            });
        }

        return $direct
            ->merge($query->orderByDesc('prioridad')->orderByDesc('updated_at')->limit($limit - $direct->count())->get())
            ->take($limit)
            ->values();
    }
}
