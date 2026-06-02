<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectoPagoAplicacion extends Model
{
    use HasUuid;

    protected $table = 'proyecto_pago_aplicaciones';

    protected $fillable = [
        'pago_id',
        'cargo_id',
        'monto_aplicado',
        'created_by_id',
    ];

    protected $casts = [
        'monto_aplicado' => 'decimal:2',
    ];

    public function pago(): BelongsTo
    {
        return $this->belongsTo(ProyectoPago::class, 'pago_id');
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(ProyectoCargo::class, 'cargo_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
