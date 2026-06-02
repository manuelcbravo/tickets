<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLog extends Model
{
    use HasUuid;

    public const CHANNELS = ['system', 'email', 'webhook'];
    public const DIRECTIONS = ['inbound', 'outbound'];
    public const STATUSES = ['pending', 'queued', 'sent', 'failed', 'cancelled', 'received'];

    protected $fillable = [
        'integration_id',
        'ticket_id',
        'user_id',
        'cliente_id',
        'contacto_id',
        'channel',
        'direction',
        'recipient',
        'subject',
        'message',
        'payload',
        'status',
        'sent_at',
        'failed_at',
        'error_message',
    ];

    protected $casts = [
        'payload' => 'array',
        'sent_at' => 'datetime',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function contacto(): BelongsTo
    {
        return $this->belongsTo(ClienteContacto::class, 'contacto_id');
    }
}
