<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectoActividadTicket extends Model
{
    use HasUuid;

    public const TIPOS = ['ejecucion', 'soporte', 'bug', 'cambio', 'seguimiento', 'relacionado'];

    protected $table = 'proyecto_actividad_tickets';

    protected $fillable = [
        'actividad_id',
        'ticket_id',
        'tipo_relacion',
        'created_by_id',
    ];

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(ProyectoActividad::class, 'actividad_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
