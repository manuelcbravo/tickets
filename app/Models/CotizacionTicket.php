<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CotizacionTicket extends Model
{
    use HasUuid;

    public const TIPOS_RELACION = ['origen', 'derivado', 'ejecucion', 'relacionado'];

    protected $fillable = [
        'cotizacion_id',
        'ticket_id',
        'tipo_relacion',
        'created_by_id',
    ];

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
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
