<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CotizacionItem extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['analisis', 'desarrollo', 'soporte', 'mantenimiento', 'integracion', 'diseño', 'qa', 'despliegue', 'capacitacion', 'servicio', 'otro'];

    protected $fillable = [
        'cotizacion_id',
        'titulo',
        'descripcion',
        'tipo',
        'cantidad',
        'unidad',
        'precio_unitario',
        'subtotal',
        'horas_estimadas',
        'orden',
        'es_opcional',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'horas_estimadas' => 'integer',
        'orden' => 'integer',
        'es_opcional' => 'boolean',
    ];

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }
}
