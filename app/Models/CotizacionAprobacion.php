<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CotizacionAprobacion extends Model
{
    use HasUuid;

    public const TIPOS = ['interna', 'cliente', 'direccion'];
    public const ESTADOS = ['pendiente', 'aprobada', 'rechazada'];

    protected $table = 'cotizacion_aprobaciones';

    protected $fillable = [
        'cotizacion_id',
        'usuario_id',
        'tipo',
        'estado',
        'comentario',
        'nombre_aprobador',
        'email_aprobador',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
