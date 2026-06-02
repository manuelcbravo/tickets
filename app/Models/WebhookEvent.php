<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebhookEvent extends Model
{
    use HasUuid;

    public const STATUSES = ['received', 'processing', 'processed', 'ignored', 'failed', 'linked'];

    protected $fillable = [
        'integration_id',
        'provider',
        'event_type',
        'external_id',
        'related_type',
        'related_id',
        'ticket_id',
        'payload',
        'headers',
        'status',
        'processed_at',
        'failed_at',
        'error_message',
    ];

    protected $casts = [
        'payload' => 'array',
        'headers' => 'array',
        'processed_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integracion::class, 'integration_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
