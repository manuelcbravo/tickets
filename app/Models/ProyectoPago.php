<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoPago extends Model
{
    use HasUuid, SoftDeletes;

    public const METODOS = ['efectivo', 'transferencia', 'spei', 'tarjeta', 'deposito', 'cheque', 'otro'];
    public const ESTADOS = ['registrado', 'confirmado', 'rechazado', 'cancelado'];

    protected $table = 'proyecto_pagos';

    protected $fillable = [
        'folio',
        'cliente_id',
        'proyecto_id',
        'fecha_pago',
        'moneda',
        'monto',
        'metodo_pago',
        'referencia',
        'banco',
        'cuenta_origen',
        'notas',
        'estado',
        'registrado_por_id',
        'confirmado_por_id',
        'confirmado_at',
        'cancelado_por_id',
        'cancelado_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
        'confirmado_at' => 'datetime',
        'cancelado_at' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function aplicaciones(): HasMany
    {
        return $this->hasMany(ProyectoPagoAplicacion::class, 'pago_id');
    }

    public function cargos(): BelongsToMany
    {
        return $this->belongsToMany(ProyectoCargo::class, 'proyecto_pago_aplicaciones', 'pago_id', 'cargo_id')
            ->withPivot(['id', 'monto_aplicado'])
            ->withTimestamps();
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(ProyectoPagoDocumento::class, 'pago_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por_id');
    }

    public function confirmadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmado_por_id');
    }

    public function canceladoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelado_por_id');
    }

    public function getMontoAplicadoAttribute(): float
    {
        return (float) $this->aplicaciones()->sum('monto_aplicado');
    }

    public function getSaldoDisponibleAttribute(): float
    {
        return max(0, (float) $this->monto - $this->monto_aplicado);
    }
}
