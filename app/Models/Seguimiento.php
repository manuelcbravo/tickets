<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seguimiento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_relacion',
        'tabla_relacion',
        'titulo',
        'seguimiento',
        'tipo_id',
        'estado',
        'prioridad',
        'fecha_seguimiento',
        'fecha_proxima_accion',
        'resultado',
        'observaciones',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    protected $casts = [
        'fecha_seguimiento' => 'date',
        'fecha_proxima_accion' => 'date',
    ];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(CatSeguimientoTipo::class, 'tipo_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
}
