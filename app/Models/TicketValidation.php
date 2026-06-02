<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketValidation extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['interna', 'soporte', 'qa', 'cliente', 'direccion'];
    public const STATUSES = ['pendiente', 'aprobado', 'rechazado'];

    protected $fillable = [
        'ticket_id',
        'validated_by_id',
        'tipo',
        'status',
        'comentario',
        'validated_at',
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by_id');
    }
}
