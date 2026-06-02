<?php

namespace App\Services\Development;

use App\Models\Repositorio;
use Illuminate\Validation\ValidationException;

class RepositoryService
{
    public function create(array $data, ?int $userId = null): Repositorio
    {
        $this->ensureUniqueUrl($data['proyecto_id'], $data['url']);

        return Repositorio::query()->create([
            ...$data,
            'rama_principal' => $data['rama_principal'] ?? 'main',
            'activo' => $data['activo'] ?? true,
            'created_by_id' => $userId,
            'updated_by_id' => $userId,
        ]);
    }

    public function update(Repositorio $repositorio, array $data, ?int $userId = null): Repositorio
    {
        $proyectoId = $data['proyecto_id'] ?? $repositorio->proyecto_id;
        $url = $data['url'] ?? $repositorio->url;
        $this->ensureUniqueUrl($proyectoId, $url, $repositorio->id);

        $repositorio->update([
            ...$data,
            'updated_by_id' => $userId,
        ]);

        return $repositorio;
    }

    public function delete(Repositorio $repositorio): void
    {
        $repositorio->delete();
    }

    private function ensureUniqueUrl(string $proyectoId, string $url, ?string $ignoreId = null): void
    {
        $exists = Repositorio::query()
            ->where('proyecto_id', $proyectoId)
            ->where('url', $url)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'url' => 'Ya existe un repositorio con esta URL en el proyecto.',
            ]);
        }
    }
}
