<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoPlanCobro extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['unico', 'parcialidades', 'mensual'];
    public const PERIODICIDADES = ['mensual'];
    public const ESTADOS = ['activo', 'pausado', 'terminado', 'cancelado'];

    protected $table = 'proyecto_planes_cobro';

    protected $fillable = [
        'proyecto_id',
        'cliente_id',
        'tipo_cobro',
        'moneda',
        'monto_total',
        'monto_mensual',
        'dia_vencimiento',
        'fecha_inicio',
        'fecha_fin',
        'periodicidad',
        'activo',
        'estado',
        'notas',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'monto_total' => 'decimal:2',
        'monto_mensual' => 'decimal:2',
        'dia_vencimiento' => 'integer',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function cargos(): HasMany
    {
        return $this->hasMany(ProyectoCargo::class, 'plan_cobro_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }
}
