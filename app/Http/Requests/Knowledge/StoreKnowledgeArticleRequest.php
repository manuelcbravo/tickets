<?php

namespace App\Http\Requests\Knowledge;

use App\Models\Proyecto;
use App\Models\ProyectoModulo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKnowledgeArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge($this->normalizeNullableIds());
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'resumen' => ['nullable', 'string'],
            'contenido' => ['required', 'string', 'min:10'],
            'category_id' => ['nullable', 'uuid', 'exists:knowledge_categories,id'],
            'cliente_id' => ['nullable', 'uuid', 'exists:clients,id'],
            'proyecto_id' => ['nullable', 'uuid', 'exists:projects,id'],
            'proyecto_modulo_id' => ['nullable', 'uuid', 'exists:project_modules,id'],
            'tipo' => ['required', 'string', Rule::in(\App\Models\KnowledgeArticle::TIPOS)],
            'visibilidad' => ['required', 'string', Rule::in(\App\Models\KnowledgeArticle::VISIBILIDADES)],
            'estatus' => ['nullable', 'string', Rule::in(\App\Models\KnowledgeArticle::ESTATUS)],
            'prioridad' => ['nullable', 'integer', 'min:0'],
            'tags' => ['nullable'],
        ];
    }

    public function after(): array
    {
        return [
            function ($validator): void {
                if ($this->input('visibilidad') === 'cliente' && blank($this->input('cliente_id'))) {
                    $validator->errors()->add('cliente_id', 'El cliente es obligatorio para visibilidad por cliente.');
                }

                if ($this->input('visibilidad') === 'proyecto' && blank($this->input('proyecto_id'))) {
                    $validator->errors()->add('proyecto_id', 'El proyecto es obligatorio para visibilidad por proyecto.');
                }

                if ($this->input('estatus') === 'publicado' && ! $this->user()?->can('knowledge.publish')) {
                    $validator->errors()->add('estatus', 'No tienes permiso para publicar articulos.');
                }

                $this->validateProjectConsistency($validator);
            },
        ];
    }

    protected function validateProjectConsistency($validator): void
    {
        $projectId = $this->input('proyecto_id');
        $clientId = $this->input('cliente_id');
        $moduleId = $this->input('proyecto_modulo_id');

        if ($projectId && $clientId) {
            $belongs = Proyecto::query()
                ->whereKey($projectId)
                ->where('client_id', $clientId)
                ->exists();

            if (! $belongs) {
                $validator->errors()->add('proyecto_id', 'El proyecto no pertenece al cliente seleccionado.');
            }
        }

        if ($moduleId && $projectId) {
            $belongs = ProyectoModulo::query()
                ->whereKey($moduleId)
                ->where('project_id', $projectId)
                ->exists();

            if (! $belongs) {
                $validator->errors()->add('proyecto_modulo_id', 'El modulo no pertenece al proyecto seleccionado.');
            }
        }
    }

    protected function normalizeNullableIds(): array
    {
        return collect(['category_id', 'cliente_id', 'proyecto_id', 'proyecto_modulo_id'])
            ->mapWithKeys(fn (string $key): array => [$key => in_array($this->input($key), ['', 'none', 'todos'], true) ? null : $this->input($key)])
            ->all();
    }
}
