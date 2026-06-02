<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlaPoliticaPrioridad extends Model
{
    use HasUuid;

    protected $table = 'sla_politica_prioridades';

    protected $fillable = [
        'sla_politica_id',
        'prioridad_id',
        'tiempo_primera_respuesta_min',
        'tiempo_resolucion_min',
        'tiempo_alerta_min',
    ];

    protected $casts = [
        'tiempo_primera_respuesta_min' => 'integer',
        'tiempo_resolucion_min' => 'integer',
        'tiempo_alerta_min' => 'integer',
    ];

    public function politica(): BelongsTo
    {
        return $this->belongsTo(SlaPolitica::class, 'sla_politica_id');
    }

    public function prioridad(): BelongsTo
    {
        return $this->belongsTo(CatTicketPrioridad::class, 'prioridad_id');
    }
}
