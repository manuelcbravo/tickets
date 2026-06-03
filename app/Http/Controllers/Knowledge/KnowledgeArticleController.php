<?php

namespace App\Http\Controllers\Knowledge;

use App\Http\Controllers\Controller;
use App\Http\Requests\Knowledge\CreateKnowledgeFromTicketRequest;
use App\Http\Requests\Knowledge\StoreKnowledgeArticleRequest;
use App\Http\Requests\Knowledge\UpdateKnowledgeArticleRequest;
use App\Models\Client;
use App\Models\File;
use App\Models\KnowledgeArticle;
use App\Models\KnowledgeArticleVersion;
use App\Models\KnowledgeCategory;
use App\Models\Proyecto;
use App\Models\ProyectoModulo;
use App\Models\Ticket;
use App\Services\Knowledge\KnowledgeArticleService;
use App\Services\Knowledge\KnowledgeFromTicketService;
use App\Services\Knowledge\KnowledgeSearchService;
use App\Services\Knowledge\TicketKnowledgeArticleService;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class KnowledgeArticleController extends Controller
{
    public function index(Request $request, KnowledgeSearchService $search): Response
    {
        return Inertia::render('knowledge/index', [
            'articles' => $search->query($request)->paginate(15)->withQueryString(),
            'filters' => $request->only(['search', 'category_id', 'cliente_id', 'proyecto_id', 'proyecto_modulo_id', 'tipo', 'visibilidad', 'estatus']),
            'metrics' => $this->metrics(),
            ...$this->options(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('knowledge/create', [
            ...$this->options(),
            'defaults' => [],
        ]);
    }

    public function store(StoreKnowledgeArticleRequest $request, KnowledgeArticleService $service): RedirectResponse
    {
        $article = $service->create($request->validated(), $request->user()->id);

        return redirect()->route('knowledge.show', $article)->with('success', 'Articulo creado correctamente.');
    }

    public function show(KnowledgeArticle $article): Response
    {
        $article->load([
            'category:id,nombre',
            'cliente:id,nombre,razon_social',
            'proyecto:id,nombre',
            'modulo:id,nombre',
            'fuenteTicket:id,folio,titulo',
            'creadoPor:id,name',
            'actualizadoPor:id,name',
            'publicadoPor:id,name',
            'tickets:id,folio,titulo,estado_id,closed_at',
            'tickets.estado:id,nombre',
            'versions.changedBy:id,name',
        ]);

        $files = File::query()
            ->where('related_table', 'knowledge_articles')
            ->where('related_uuid', $article->id)
            ->latest()
            ->get();

        $linkedTicketIds = $article->tickets->pluck('id');
        $availableTickets = Ticket::query()
            ->when($article->proyecto_id, fn ($q) => $q->where('proyecto_id', $article->proyecto_id))
            ->whereNotIn('id', $linkedTicketIds)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get(['id', 'folio', 'titulo']);

        return Inertia::render('knowledge/show', [
            'article' => $article,
            'files' => $files,
            'availableTickets' => $availableTickets,
        ]);
    }

    public function edit(KnowledgeArticle $article): Response
    {
        $files = File::query()
            ->where('related_table', 'knowledge_articles')
            ->where('related_uuid', $article->id)
            ->latest()
            ->get();

        return Inertia::render('knowledge/edit', [
            'article' => $article,
            'files' => $files,
            ...$this->options(),
        ]);
    }

    public function update(UpdateKnowledgeArticleRequest $request, KnowledgeArticle $article, KnowledgeArticleService $service): RedirectResponse
    {
        $service->update($article, $request->validated(), $request->user()->id);

        return redirect()->route('knowledge.show', $article)->with('success', 'Articulo actualizado correctamente.');
    }

    public function destroy(KnowledgeArticle $article, KnowledgeArticleService $service): RedirectResponse
    {
        $service->delete($article);

        return redirect()->route('knowledge.index')->with('success', 'Articulo eliminado correctamente.');
    }

    public function publish(KnowledgeArticle $article, KnowledgeArticleService $service, TicketHistoryService $history): RedirectResponse
    {
        $service->publish($article, request()->user()->id);

        if ($article->fuente_ticket_id) {
            $ticket = Ticket::query()->find($article->fuente_ticket_id);

            if ($ticket) {
                $history->log(
                    $ticket,
                    'knowledge_article_published_from_ticket',
                    request()->user()->id,
                    descripcion: 'Articulo de conocimiento publicado desde ticket.',
                    metadata: ['article_id' => $article->id, 'article_title' => $article->titulo],
                );
            }
        }

        return back()->with('success', 'Articulo publicado correctamente.');
    }

    public function archive(KnowledgeArticle $article, KnowledgeArticleService $service): RedirectResponse
    {
        $service->archive($article, request()->user()->id);

        return back()->with('success', 'Articulo archivado correctamente.');
    }

    public function linkTicket(Request $request, KnowledgeArticle $article, TicketKnowledgeArticleService $service): RedirectResponse
    {
        $validated = $request->validate([
            'ticket_id' => ['required', 'uuid', 'exists:tickets,id'],
            'tipo_relacion' => ['required', 'string', Rule::in(['solucion', 'relacionado', 'referencia', 'creado_desde_ticket', 'respuesta_sugerida'])],
            'notas' => ['nullable', 'string', 'max:500'],
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);
        $service->link($ticket, $article, $validated, $request->user()->id);

        return back()->with('success', 'Ticket vinculado correctamente.');
    }

    public function unlinkTicket(KnowledgeArticle $article, Ticket $ticket, TicketKnowledgeArticleService $service): RedirectResponse
    {
        $service->unlink($ticket, $article, request()->user()->id);

        return back()->with('success', 'Ticket desvinculado correctamente.');
    }

    public function restoreVersion(Request $request, KnowledgeArticle $article, KnowledgeArticleVersion $version, KnowledgeArticleService $service): RedirectResponse
    {
        abort_unless($version->knowledge_article_id === $article->id, 404);

        $service->createVersion($article, $request->user()->id, "Auto-guardado antes de restaurar version {$version->version}.");

        $article->update([
            'titulo' => $version->titulo,
            'resumen' => $version->resumen,
            'contenido' => $version->contenido,
            'actualizado_por_id' => $request->user()->id,
        ]);

        return back()->with('success', "Articulo restaurado a la version {$version->version}.");
    }

    public function createFromTicket(Ticket $ticket, KnowledgeFromTicketService $service): Response
    {
        return Inertia::render('knowledge/create', [
            ...$this->options(),
            'defaults' => $service->defaults($ticket),
            'sourceTicket' => $ticket->only(['id', 'folio', 'titulo']),
        ]);
    }

    public function storeFromTicket(CreateKnowledgeFromTicketRequest $request, Ticket $ticket, KnowledgeFromTicketService $service): RedirectResponse
    {
        $article = $service->create($ticket, $request->validated(), $request->user()->id);

        return redirect()->route('knowledge.show', $article)->with('success', 'Articulo creado desde ticket correctamente.');
    }

    private function options(): array
    {
        return [
            'categories' => KnowledgeCategory::query()->where('activo', true)->orderBy('orden')->orderBy('nombre')->get(['id', 'nombre', 'parent_id', 'proyecto_id']),
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre', 'razon_social']),
            'proyectos' => Proyecto::query()->orderBy('nombre')->get(['id', 'client_id', 'nombre']),
            'modulos' => ProyectoModulo::query()->orderBy('orden')->orderBy('nombre')->get(['id', 'project_id', 'nombre']),
            'tipos' => KnowledgeArticle::TIPOS,
            'visibilidades' => KnowledgeArticle::VISIBILIDADES,
            'estatuses' => KnowledgeArticle::ESTATUS,
        ];
    }

    private function metrics(): array
    {
        return [
            'total' => KnowledgeArticle::query()->count(),
            'published' => KnowledgeArticle::query()->where('estatus', 'publicado')->count(),
            'drafts' => KnowledgeArticle::query()->where('estatus', 'borrador')->count(),
            'internal' => KnowledgeArticle::query()->where('visibilidad', 'interna')->count(),
            'public' => KnowledgeArticle::query()->where('visibilidad', 'publica')->count(),
            'documentedTickets' => Ticket::query()->whereHas('knowledgeArticles')->count(),
            'closedWithoutDocumentation' => Ticket::query()->whereNotNull('closed_at')->whereDoesntHave('knowledgeArticles')->count(),
        ];
    }
}
