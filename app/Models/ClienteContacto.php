<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteContacto extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['solicitante', 'aprobador', 'tecnico', 'facturacion', 'direccion', 'otro'];

    protected $table = 'client_contacts';

    protected $fillable = [
        'client_id',
        'nombre',
        'email',
        'telefono',
        'puesto',
        'tipo_contacto',
        'es_principal',
        'recibe_notificaciones',
        'notas',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'recibe_notificaciones' => 'boolean',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(NotificationLog::class, 'contacto_id');
    }

    public function externalMessages(): HasMany
    {
        return $this->hasMany(ExternalMessage::class, 'contacto_id');
    }
}
