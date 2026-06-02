<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketReopenLog extends Model
{
    use HasUuid;

    public const ROOT_CAUSES = [
        'mala_interpretacion',
        'falta_de_pruebas',
        'bug_secundario',
        'alcance_incompleto',
        'error_cliente',
        'deploy_incompleto',
        'regresion',
        'datos_incorrectos',
        'otro',
    ];

    protected $fillable = [
        'ticket_id',
        'reopened_by_id',
        'previous_closed_at',
        'reason',
        'root_cause',
        'notes',
    ];

    protected $casts = [
        'previous_closed_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function reopenedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reopened_by_id');
    }
}
