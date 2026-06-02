<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use HasUuid, SoftDeletes;
    protected $table = 'cotizaciones';

    public const ESTADOS = [
        'borrador',
        'en_revision_interna',
        'aprobada_internamente',
        'enviada',
        'aprobada_cliente',
        'rechazada_cliente',
        'cancelada',
        'convertida',
    ];

    protected $fillable = [
        'uuid',
        'folio',
        'cliente_id',
        'proyecto_id',
        'ticket_origen_id',
        'contacto_id',
        'creado_por_id',
        'aprobado_internamente_por_id',
        'aprobado_cliente_por_id',
        'titulo',
        'descripcion',
        'alcance',
        'exclusiones',
        'entregables',
        'condiciones',
        'notas_internas',
        'moneda',
        'subtotal',
        'descuento',
        'impuesto',
        'total',
        'horas_estimadas',
        'dias_estimados',
        'fecha_estimada_inicio',
        'fecha_estimada_entrega',
        'estado',
        'enviada_at',
        'aprobada_internamente_at',
        'aprobada_cliente_at',
        'rechazada_at',
        'cancelada_at',
        'convertida_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'total' => 'decimal:2',
        'horas_estimadas' => 'integer',
        'dias_estimados' => 'integer',
        'fecha_estimada_inicio' => 'date',
        'fecha_estimada_entrega' => 'date',
        'enviada_at' => 'datetime',
        'aprobada_internamente_at' => 'datetime',
        'aprobada_cliente_at' => 'datetime',
        'rechazada_at' => 'datetime',
        'cancelada_at' => 'datetime',
        'convertida_at' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function ticketOrigen(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_origen_id');
    }

    public function contacto(): BelongsTo
    {
        return $this->belongsTo(ClienteContacto::class, 'contacto_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por_id');
    }

    public function aprobadoInternamentePor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_internamente_por_id');
    }

    public function aprobadoClientePor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_cliente_por_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CotizacionItem::class)->orderBy('orden')->orderBy('created_at');
    }

    public function aprobaciones(): HasMany
    {
        return $this->hasMany(CotizacionAprobacion::class)->latest();
    }

    public function cotizacionTickets(): HasMany
    {
        return $this->hasMany(CotizacionTicket::class);
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'cotizacion_tickets')
            ->withPivot(['id', 'tipo_relacion', 'created_by_id'])
            ->withTimestamps();
    }
}
