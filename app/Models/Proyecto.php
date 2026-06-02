<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    use HasUuid, SoftDeletes;

    public const ESTADOS = ['mantenimiento', 'desarrollo', 'legado', 'congelado', 'sin_soporte', 'cerrado'];
    public const CRITICIDADES = ['baja', 'media', 'alta', 'critica'];
    public const ESTADOS_PLANEACION = ['borrador', 'planeado', 'en_proceso', 'pausado', 'en_riesgo', 'terminado', 'cancelado'];
    public const PRIORIDADES_PLANEACION = ['baja', 'media', 'alta', 'critica'];

    protected $table = 'projects';

    protected $fillable = [
        'client_id',
        'nombre',
        'descripcion',
        'url_produccion',
        'url_staging',
        'repositorio_url',
        'documentacion_url',
        'tecnologia',
        'responsable_tecnico_id',
        'estado',
        'billing_status',
        'saldo_pendiente',
        'saldo_vencido',
        'ultimo_pago_at',
        'proximo_vencimiento_at',
        'criticidad',
        'notas_internas',
        'objetivo',
        'alcance',
        'descripcion_funcional',
        'descripcion_tecnica',
        'restricciones',
        'notas_planeacion',
        'fecha_inicio',
        'fecha_objetivo',
        'estado_planeacion',
        'responsable_planeacion_id',
        'prioridad_planeacion',
        'avance_porcentaje',
    ];

    protected $casts = [
        'saldo_pendiente' => 'decimal:2',
        'saldo_vencido' => 'decimal:2',
        'ultimo_pago_at' => 'datetime',
        'proximo_vencimiento_at' => 'datetime',
        'fecha_inicio' => 'date',
        'fecha_objetivo' => 'date',
        'avance_porcentaje' => 'integer',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function modulos(): HasMany
    {
        return $this->hasMany(ProyectoModulo::class, 'project_id')->orderBy('orden')->orderBy('nombre');
    }

    public function ambientes(): HasMany
    {
        return $this->hasMany(Ambiente::class, 'project_id')->orderBy('nombre');
    }

    public function repositorios(): HasMany
    {
        return $this->hasMany(Repositorio::class, 'proyecto_id')->orderBy('nombre');
    }

    public function releases(): HasMany
    {
        return $this->hasMany(Release::class, 'proyecto_id')->latest();
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'proyecto_id')->latest();
    }

    public function planCobro(): HasOne
    {
        return $this->hasOne(ProyectoPlanCobro::class, 'proyecto_id')
            ->where('activo', true)
            ->where('estado', 'activo')
            ->latest('created_at');
    }

    public function planesCobro(): HasMany
    {
        return $this->hasMany(ProyectoPlanCobro::class, 'proyecto_id')->latest();
    }

    public function cargos(): HasMany
    {
        return $this->hasMany(ProyectoCargo::class, 'proyecto_id')->latest('fecha_vencimiento');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(ProyectoPago::class, 'proyecto_id')->latest('fecha_pago');
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'related_uuid', 'id')
            ->where('related_table', 'projects')
            ->latest();
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(ProyectoActividad::class, 'proyecto_id')->orderBy('orden')->latest();
    }

    public function actividadTiempos(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProyectoActividadTiempo::class,
            ProyectoActividad::class,
            'proyecto_id',
            'actividad_id',
            'id',
            'id',
        );
    }

    public function responsableTecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_tecnico_id');
    }

    public function responsablePlaneacion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_planeacion_id');
    }
}
