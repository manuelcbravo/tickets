<?php

namespace App\Services\Knowledge;

use App\Models\KnowledgeArticle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class KnowledgeArticleService
{
    public function create(array $data, int $usuarioId): KnowledgeArticle
    {
        return DB::transaction(function () use ($data, $usuarioId): KnowledgeArticle {
            return KnowledgeArticle::query()->create([
                ...$this->normalize($data),
                'slug' => $this->uniqueSlug($data['titulo']),
                'estatus' => $data['estatus'] ?? 'borrador',
                'creado_por_id' => $usuarioId,
                'actualizado_por_id' => $usuarioId,
            ]);
        });
    }

    public function update(KnowledgeArticle $article, array $data, int $usuarioId): KnowledgeArticle
    {
        return DB::transaction(function () use ($article, $data, $usuarioId): KnowledgeArticle {
            if (in_array($article->estatus, ['publicado', 'en_revision'], true)) {
                $this->createVersion($article, $usuarioId, $data['change_summary'] ?? 'Actualizacion del articulo.');
            }

            if (($data['titulo'] ?? $article->titulo) !== $article->titulo) {
                $data['slug'] = $this->uniqueSlug($data['titulo'], $article->id);
            }

            $article->update([
                ...$this->normalize($data),
                'actualizado_por_id' => $usuarioId,
            ]);

            return $article->refresh();
        });
    }

    public function publish(KnowledgeArticle $article, int $usuarioId): KnowledgeArticle
    {
        if (blank($article->contenido)) {
            throw ValidationException::withMessages([
                'contenido' => 'No se puede publicar un articulo sin contenido.',
            ]);
        }

        $article->update([
            'estatus' => 'publicado',
            'published_at' => now(),
            'publicado_por_id' => $usuarioId,
            'archived_at' => null,
        ]);

        return $article->refresh();
    }

    public function archive(KnowledgeArticle $article, int $usuarioId): KnowledgeArticle
    {
        $article->update([
            'estatus' => 'archivado',
            'archived_at' => now(),
            'actualizado_por_id' => $usuarioId,
        ]);

        return $article->refresh();
    }

    public function delete(KnowledgeArticle $article): void
    {
        $article->delete();
    }

    public function createVersion(KnowledgeArticle $article, int $usuarioId, ?string $summary = null): void
    {
        $nextVersion = ((int) $article->versions()->max('version')) + 1;

        $article->versions()->create([
            'version' => $nextVersion,
            'titulo' => $article->titulo,
            'resumen' => $article->resumen,
            'contenido' => $article->contenido,
            'estatus' => $article->estatus,
            'visibilidad' => $article->visibilidad,
            'changed_by_id' => $usuarioId,
            'change_summary' => $summary,
            'created_at' => now(),
        ]);
    }

    private function normalize(array $data): array
    {
        if (array_key_exists('tags', $data)) {
            $data['tags'] = $this->normalizeTags($data['tags']);
        }

        $data['category_id'] = $data['category_id'] ?? null;
        $data['cliente_id'] = $data['cliente_id'] ?? null;
        $data['proyecto_id'] = $data['proyecto_id'] ?? null;
        $data['proyecto_modulo_id'] = $data['proyecto_modulo_id'] ?? null;
        $data['prioridad'] = $data['prioridad'] ?? 0;

        unset($data['change_summary']);

        return $data;
    }

    private function normalizeTags(mixed $tags): array
    {
        if (is_string($tags)) {
            return collect(explode(',', $tags))
                ->map(fn (string $tag): string => trim($tag))
                ->filter()
                ->values()
                ->all();
        }

        if (! is_array($tags)) {
            return [];
        }

        return collect($tags)
            ->map(fn ($tag): string => trim((string) $tag))
            ->filter()
            ->values()
            ->all();
    }

    private function uniqueSlug(string $title, ?string $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'articulo';
        $slug = $base;
        $counter = 2;

        while (KnowledgeArticle::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
