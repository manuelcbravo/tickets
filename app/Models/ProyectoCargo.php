<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoCargo extends Model
{
    use HasUuid, SoftDeletes;

    public const ESTADOS = ['pendiente', 'pagado_parcial', 'pagado', 'vencido', 'cancelado', 'condonado'];

    protected $table = 'proyecto_cargos';

    protected $fillable = [
        'folio',
        'cliente_id',
        'proyecto_id',
        'plan_cobro_id',
        'cotizacion_id',
        'concepto',
        'descripcion',
        'periodo_inicio',
        'periodo_fin',
        'fecha_emision',
        'fecha_vencimiento',
        'moneda',
        'monto',
        'monto_pagado',
        'saldo',
        'estado',
        'created_by_id',
        'updated_by_id',
        'cancelled_by_id',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'saldo' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function planCobro(): BelongsTo
    {
        return $this->belongsTo(ProyectoPlanCobro::class, 'plan_cobro_id');
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }

    public function aplicaciones(): HasMany
    {
        return $this->hasMany(ProyectoPagoAplicacion::class, 'cargo_id');
    }

    public function pagos(): BelongsToMany
    {
        return $this->belongsToMany(ProyectoPago::class, 'proyecto_pago_aplicaciones', 'cargo_id', 'pago_id')
            ->withPivot(['id', 'monto_aplicado'])
            ->withTimestamps();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by_id');
    }
}
