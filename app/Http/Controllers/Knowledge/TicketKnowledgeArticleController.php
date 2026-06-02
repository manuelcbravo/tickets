<?php

namespace App\Http\Controllers\Knowledge;

use App\Http\Controllers\Controller;
use App\Http\Requests\Knowledge\LinkTicketKnowledgeArticleRequest;
use App\Models\KnowledgeArticle;
use App\Models\Ticket;
use App\Services\Knowledge\TicketKnowledgeArticleService;
use Illuminate\Http\RedirectResponse;

class TicketKnowledgeArticleController extends Controller
{
    public function store(LinkTicketKnowledgeArticleRequest $request, Ticket $ticket, TicketKnowledgeArticleService $service): RedirectResponse
    {
        $article = KnowledgeArticle::query()->findOrFail($request->validated('knowledge_article_id'));
        $service->link($ticket, $article, $request->validated(), $request->user()->id);

        return back()->with('success', 'Articulo relacionado correctamente.');
    }

    public function destroy(Ticket $ticket, KnowledgeArticle $article, TicketKnowledgeArticleService $service): RedirectResponse
    {
        $service->unlink($ticket, $article, request()->user()->id);

        return back()->with('success', 'Relacion eliminada correctamente.');
    }
}
