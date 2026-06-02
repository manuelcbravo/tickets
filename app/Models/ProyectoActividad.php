<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoActividad extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['tarea', 'subtarea', 'bug', 'mejora', 'investigacion', 'documentacion', 'reunion', 'qa', 'deploy', 'otro'];
    public const ESTADOS = ['pendiente', 'por_hacer', 'en_proceso', 'en_revision', 'bloqueada', 'terminada', 'cancelada'];
    public const PRIORIDADES = ['baja', 'media', 'alta', 'critica'];
    public const KANBAN_COLUMNS = ['backlog', 'por_hacer', 'en_proceso', 'en_revision', 'terminado'];

    protected $table = 'proyecto_actividades';

    protected $fillable = [
        'proyecto_id',
        'ticket_id',
        'parent_id',
        'titulo',
        'descripcion',
        'tipo',
        'estado',
        'prioridad',
        'responsable_id',
        'reportado_por_id',
        'fecha_inicio',
        'fecha_limite',
        'fecha_finalizacion',
        'minutos_estimados',
        'minutos_reales',
        'orden',
        'kanban_column',
        'tags',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_limite' => 'date',
        'fecha_finalizacion' => 'datetime',
        'minutos_estimados' => 'integer',
        'minutos_reales' => 'integer',
        'orden' => 'integer',
        'tags' => 'array',
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('orden')->orderBy('titulo');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function reportadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reportado_por_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function tiempos(): HasMany
    {
        return $this->hasMany(ProyectoActividadTiempo::class, 'actividad_id')->latest('fecha');
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'related_uuid', 'id')
            ->where('related_table', 'proyecto_actividades')
            ->latest();
    }

    public function ticketLinks(): HasMany
    {
        return $this->hasMany(ProyectoActividadTicket::class, 'actividad_id');
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'proyecto_actividad_tickets', 'actividad_id', 'ticket_id')
            ->withPivot(['id', 'tipo_relacion', 'created_by_id'])
            ->withTimestamps();
    }
}
