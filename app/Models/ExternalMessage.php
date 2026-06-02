<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalMessage extends Model
{
    use HasUuid;

    public const CHANNELS = ['email', 'webhook', 'github', 'gitlab', 'bitbucket', 'system', 'other'];

    protected $fillable = [
        'integration_id',
        'ticket_id',
        'cliente_id',
        'contacto_id',
        'channel',
        'external_id',
        'sender',
        'recipient',
        'message',
        'attachments',
        'payload',
        'direction',
        'received_at',
        'sent_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'payload' => 'array',
        'received_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integracion::class, 'integration_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
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
