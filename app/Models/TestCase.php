<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestCase extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['manual', 'funcional', 'regresion', 'smoke', 'seguridad', 'rendimiento', 'ux', 'datos', 'integracion'];

    protected $fillable = [
        'ticket_id',
        'proyecto_id',
        'proyecto_modulo_id',
        'titulo',
        'descripcion',
        'pasos',
        'resultado_esperado',
        'tipo',
        'prioridad',
        'activo',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(ProyectoModulo::class, 'proyecto_modulo_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(TicketTestResult::class);
    }
}
