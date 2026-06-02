<?php

namespace App\Http\Requests\Tickets\Concerns;

use App\Models\Ambiente;
use App\Models\ClienteContacto;
use App\Models\Proyecto;
use App\Models\ProyectoModulo;
use Illuminate\Validation\Validator;

trait ValidatesTicketRelations
{
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $clienteId = $this->input('cliente_id');
            $proyectoId = $this->input('proyecto_id');

            if ($proyectoId && $clienteId && ! Proyecto::query()
                ->whereKey($proyectoId)
                ->where('client_id', $clienteId)
                ->exists()) {
                $validator->errors()->add('proyecto_id', 'El proyecto no pertenece al cliente seleccionado.');
            }

            if ($this->input('contacto_id') && $clienteId && ! ClienteContacto::query()
                ->whereKey($this->input('contacto_id'))
                ->where('client_id', $clienteId)
                ->exists()) {
                $validator->errors()->add('contacto_id', 'El contacto no pertenece al cliente seleccionado.');
            }

            if ($this->input('proyecto_modulo_id') && $proyectoId && ! ProyectoModulo::query()
                ->whereKey($this->input('proyecto_modulo_id'))
                ->where('project_id', $proyectoId)
                ->exists()) {
                $validator->errors()->add('proyecto_modulo_id', 'El modulo no pertenece al proyecto seleccionado.');
            }

            if ($this->input('ambiente_id') && $proyectoId && ! Ambiente::query()
                ->whereKey($this->input('ambiente_id'))
                ->where('project_id', $proyectoId)
                ->exists()) {
                $validator->errors()->add('ambiente_id', 'El ambiente no pertenece al proyecto seleccionado.');
            }
        });
    }
}
