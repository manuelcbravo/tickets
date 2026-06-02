<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlaPolitica extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'sla_politicas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'es_default',
        'horario_inicio',
        'horario_fin',
        'dias_laborales',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'es_default' => 'boolean',
        'dias_laborales' => 'array',
    ];

    public function prioridades(): HasMany
    {
        return $this->hasMany(SlaPoliticaPrioridad::class, 'sla_politica_id');
    }

    public function ticketSlas(): HasMany
    {
        return $this->hasMany(TicketSla::class, 'sla_politica_id');
    }
}
