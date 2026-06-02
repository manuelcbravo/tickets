<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketDevelopmentTask extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['bugfix', 'feature', 'hotfix', 'refactor', 'chore', 'investigacion', 'documentacion'];
    public const ESTADOS = ['pendiente', 'en_desarrollo', 'pr_abierto', 'en_revision', 'aprobado', 'rechazado', 'mergeado', 'listo_para_release', 'deployado', 'cancelado'];

    protected $fillable = [
        'ticket_id',
        'proyecto_id',
        'repositorio_id',
        'asignado_a_id',
        'creado_por_id',
        'titulo',
        'descripcion',
        'tipo',
        'estado',
        'prioridad',
        'branch_name',
        'pull_request_url',
        'commit_hash',
        'estimacion_min',
        'tiempo_real_min',
        'started_at',
        'completed_at',
        'reviewed_at',
        'reviewed_by_id',
    ];

    protected $casts = [
        'estimacion_min' => 'integer',
        'tiempo_real_min' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function repositorio(): BelongsTo
    {
        return $this->belongsTo(Repositorio::class, 'repositorio_id');
    }

    public function asignadoA(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }

    public function links(): HasMany
    {
        return $this->hasMany(TicketDevelopmentLink::class, 'development_task_id');
    }

    public function releases(): BelongsToMany
    {
        return $this->belongsToMany(Release::class, 'release_tickets', 'development_task_id', 'release_id')
            ->withPivot(['id', 'ticket_id', 'notas', 'created_by_id'])
            ->withTimestamps();
    }
}
