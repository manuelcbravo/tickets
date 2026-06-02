<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{
    use HasUuid, SoftDeletes;

    public const ESTADOS = ['borrador', 'programado', 'listo', 'liberado', 'cancelado', 'fallido'];

    protected $fillable = [
        'proyecto_id',
        'ambiente_id',
        'nombre',
        'version',
        'descripcion',
        'estado',
        'release_notes',
        'scheduled_at',
        'released_at',
        'created_by_id',
        'released_by_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function ambiente(): BelongsTo
    {
        return $this->belongsTo(Ambiente::class, 'ambiente_id');
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'release_tickets')
            ->withPivot(['id', 'development_task_id', 'notas', 'created_by_id'])
            ->withTimestamps();
    }

    public function releaseTickets(): HasMany
    {
        return $this->hasMany(ReleaseTicket::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function releasedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_by_id');
    }
}
