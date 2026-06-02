<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoActividadTiempo extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'proyecto_actividad_tiempos';

    protected $fillable = [
        'actividad_id',
        'usuario_id',
        'descripcion',
        'minutos',
        'fecha',
        'iniciado_at',
        'terminado_at',
    ];

    protected $casts = [
        'minutos' => 'integer',
        'fecha' => 'date',
        'iniciado_at' => 'datetime',
        'terminado_at' => 'datetime',
    ];

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(ProyectoActividad::class, 'actividad_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
