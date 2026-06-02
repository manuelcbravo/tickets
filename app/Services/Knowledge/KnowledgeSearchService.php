<?php

namespace App\Services\Knowledge;

use App\Models\KnowledgeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KnowledgeSearchService
{
    public function query(Request $request)
    {
        return KnowledgeArticle::query()
            ->with(['category:id,nombre', 'cliente:id,nombre,razon_social', 'proyecto:id,nombre', 'modulo:id,nombre', 'actualizadoPor:id,name'])
            ->when(! $request->filled('estatus'), fn ($query) => $query->where('estatus', '!=', 'archivado'))
            ->when($request->string('search')->toString(), function ($query, string $search): void {
                $likeOperator = DB::connection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';

                $query->where(function ($nested) use ($search, $likeOperator): void {
                    $nested->where('titulo', $likeOperator, "%{$search}%")
                        ->orWhere('resumen', $likeOperator, "%{$search}%")
                        ->orWhere('contenido', $likeOperator, "%{$search}%");

                    if (DB::connection()->getDriverName() === 'pgsql') {
                        $nested->orWhereRaw('tags::text ilike ?', ["%{$search}%"]);
                    } else {
                        $nested->orWhere('tags', 'like', "%{$search}%");
                    }
                });
            })
            ->when($request->input('category_id'), fn ($query, $value) => $query->where('category_id', $value))
            ->when($request->input('cliente_id'), fn ($query, $value) => $query->where('cliente_id', $value))
            ->when($request->input('proyecto_id'), fn ($query, $value) => $query->where('proyecto_id', $value))
            ->when($request->input('proyecto_modulo_id'), fn ($query, $value) => $query->where('proyecto_modulo_id', $value))
            ->when($request->input('tipo'), fn ($query, $value) => $query->where('tipo', $value))
            ->when($request->input('visibilidad'), fn ($query, $value) => $query->where('visibilidad', $value))
            ->when($request->input('estatus'), fn ($query, $value) => $query->where('estatus', $value))
            ->when($request->input('fuente_ticket_id'), fn ($query, $value) => $query->where('fuente_ticket_id', $value))
            ->orderByRaw("CASE estatus WHEN 'publicado' THEN 0 WHEN 'en_revision' THEN 1 WHEN 'borrador' THEN 2 ELSE 3 END")
            ->orderByDesc('prioridad')
            ->orderByDesc('updated_at');
    }
}
