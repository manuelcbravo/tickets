<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketTiempo extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'ticket_tiempos';

    protected $fillable = [
        'ticket_id',
        'usuario_id',
        'descripcion',
        'minutos',
        'fecha',
        'iniciado_at',
        'terminado_at',
        'es_facturable',
        'origen',
    ];

    protected $casts = [
        'minutos' => 'integer',
        'fecha' => 'date',
        'iniciado_at' => 'datetime',
        'terminado_at' => 'datetime',
        'es_facturable' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
