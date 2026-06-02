<?php

namespace App\Http\Requests\ProjectPlanning;

class StoreGlobalProjectActivityRequest extends StoreProjectActivityRequest
{
    public function rules(): array
    {
        return [
            'proyecto_id' => ['required', 'uuid', 'exists:projects,id'],
            ...parent::rules(),
        ];
    }
}
