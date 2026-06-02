<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketChecklistItem extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'titulo',
        'descripcion',
        'tipo',
        'requerido',
        'completado',
        'completado_por_id',
        'completado_at',
        'orden',
    ];

    protected $casts = [
        'requerido' => 'boolean',
        'completado' => 'boolean',
        'completado_at' => 'datetime',
        'orden' => 'integer',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function completadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completado_por_id');
    }
}
