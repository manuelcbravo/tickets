<?php

namespace App\Services\Knowledge;

use App\Models\KnowledgeCategory;
use Illuminate\Support\Str;

class KnowledgeCategoryService
{
    public function create(array $data, int $usuarioId): KnowledgeCategory
    {
        return KnowledgeCategory::query()->create([
            ...$data,
            'slug' => $this->uniqueSlug($data['nombre']),
            'created_by_id' => $usuarioId,
            'updated_by_id' => $usuarioId,
        ]);
    }

    public function update(KnowledgeCategory $category, array $data, int $usuarioId): KnowledgeCategory
    {
        if (($data['nombre'] ?? $category->nombre) !== $category->nombre) {
            $data['slug'] = $this->uniqueSlug($data['nombre'], $category->id);
        }

        $category->update([
            ...$data,
            'updated_by_id' => $usuarioId,
        ]);

        return $category->refresh();
    }

    public function delete(KnowledgeCategory $category): void
    {
        $category->delete();
    }

    private function uniqueSlug(string $name, ?string $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'categoria';
        $slug = $base;
        $counter = 2;

        while (KnowledgeCategory::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
