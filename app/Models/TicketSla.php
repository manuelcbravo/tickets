<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketSla extends Model
{
    use HasUuid;

    protected $table = 'ticket_sla';

    protected $fillable = [
        'ticket_id',
        'sla_politica_id',
        'prioridad_id',
        'vence_primera_respuesta_at',
        'vence_resolucion_at',
        'primera_respuesta_cumplida',
        'resolucion_cumplida',
        'primera_respuesta_at',
        'resuelto_at',
        'estado_sla',
    ];

    protected $casts = [
        'vence_primera_respuesta_at' => 'datetime',
        'vence_resolucion_at' => 'datetime',
        'primera_respuesta_cumplida' => 'boolean',
        'resolucion_cumplida' => 'boolean',
        'primera_respuesta_at' => 'datetime',
        'resuelto_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function politica(): BelongsTo
    {
        return $this->belongsTo(SlaPolitica::class, 'sla_politica_id');
    }

    public function prioridad(): BelongsTo
    {
        return $this->belongsTo(CatTicketPrioridad::class, 'prioridad_id');
    }
}
