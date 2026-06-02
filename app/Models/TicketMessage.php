<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'usuario_id',
        'mensaje',
        'es_interno',
        'es_respuesta_cliente',
    ];

    protected $casts = [
        'es_interno' => 'boolean',
        'es_respuesta_cliente' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function adjuntos(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'message_id');
    }
}
