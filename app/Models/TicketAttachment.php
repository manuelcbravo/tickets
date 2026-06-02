<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class TicketAttachment extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'message_id',
        'usuario_id',
        'nombre_original',
        'ruta',
        'mime_type',
        'size',
        'disk',
        'descripcion',
    ];

    protected $appends = ['url'];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function mensaje(): BelongsTo
    {
        return $this->belongsTo(TicketMessage::class, 'message_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->ruta);
    }
}
