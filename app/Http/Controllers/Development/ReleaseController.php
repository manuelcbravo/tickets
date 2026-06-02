<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Http\Requests\Development\PublishReleaseRequest;
use App\Http\Requests\Development\StoreReleaseRequest;
use App\Http\Requests\Development\UpdateReleaseRequest;
use App\Models\Ambiente;
use App\Models\Proyecto;
use App\Models\Release;
use App\Models\Ticket;
use App\Models\TicketDevelopmentTask;
use App\Services\Development\ReleaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReleaseController extends Controller
{
    public function index(Request $request): Response
    {
        $releases = Release::query()
            ->with(['proyecto:id,nombre', 'ambiente:id,nombre'])
            ->withCount('tickets')
            ->when($request->input('proyecto_id'), fn ($query, $value) => $query->where('proyecto_id', $value))
            ->when($request->input('ambiente_id'), fn ($query, $value) => $query->where('ambiente_id', $value))
            ->when($request->input('estado'), fn ($query, $value) => $query->where('estado', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('development/releases/index', [
            'releases' => $releases,
            'filters' => $request->only(['proyecto_id', 'ambiente_id', 'estado']),
            ...$this->options(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('development/releases/create', $this->options());
    }

    public function store(StoreReleaseRequest $request, ReleaseService $service): RedirectResponse
    {
        $release = $service->create($request->validated(), $request->user()->id);

        return redirect()->route('development.releases.show', $release)->with('success', 'Release creado correctamente.');
    }

    public function show(Release $release): Response
    {
        $release->load([
            'proyecto:id,nombre',
            'ambiente:id,nombre',
            'createdBy:id,name',
            'releasedBy:id,name',
            'releaseTickets.ticket:id,folio,titulo,estado_id,prioridad_id,responsable_id,development_status',
            'releaseTickets.ticket.estado:id,nombre',
            'releaseTickets.ticket.prioridad:id,nombre',
            'releaseTickets.ticket.responsable:id,name',
            'releaseTickets.developmentTask:id,titulo,estado',
        ]);

        return Inertia::render('development/releases/show', [
            'release' => $release,
            'availableTickets' => Ticket::query()
                ->with(['prioridad:id,nombre'])
                ->where('proyecto_id', $release->proyecto_id)
                ->orderByDesc('created_at')
                ->limit(100)
                ->get(['id', 'folio', 'titulo', 'prioridad_id', 'development_status']),
            'availableTasks' => TicketDevelopmentTask::query()
                ->where('proyecto_id', $release->proyecto_id)
                ->orderBy('titulo')
                ->get(['id', 'ticket_id', 'titulo', 'estado']),
            ...$this->options(),
        ]);
    }

    public function edit(Release $release): Response
    {
        return Inertia::render('development/releases/edit', [
            'release' => $release,
            ...$this->options(),
        ]);
    }

    public function update(UpdateReleaseRequest $request, Release $release, ReleaseService $service): RedirectResponse
    {
        $service->update($release, $request->validated());

        return redirect()->route('development.releases.show', $release)->with('success', 'Release actualizado correctamente.');
    }

    public function destroy(Release $release): RedirectResponse
    {
        $release->delete();

        return redirect()->route('development.releases.index')->with('success', 'Release eliminado correctamente.');
    }

    public function publish(PublishReleaseRequest $request, Release $release, ReleaseService $service): RedirectResponse
    {
        if ($request->filled('descripcion')) {
            $release->forceFill(['descripcion' => $request->string('descripcion')->toString()])->save();
        }

        $service->publish($release, $request->user()->id);

        return back()->with('success', 'Release marcado como liberado.');
    }

    private function options(): array
    {
        return [
            'projects' => Proyecto::query()->orderBy('nombre')->get(['id', 'nombre']),
            'environments' => Ambiente::query()->orderBy('nombre')->get(['id', 'project_id', 'nombre']),
            'statusOptions' => Release::ESTADOS,
        ];
    }
}
