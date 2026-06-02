<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Integracion extends Model
{
    use HasUuid, SoftDeletes;

    public const TIPOS = ['email', 'github', 'gitlab', 'bitbucket', 'webhook', 'calendario', 'almacenamiento', 'monitoreo', 'otro'];
    public const PROVEEDORES = ['smtp', 'mailgun', 'ses', 'github', 'gitlab', 'bitbucket', 'custom'];

    protected $table = 'integraciones';

    protected $fillable = [
        'nombre',
        'tipo',
        'proveedor',
        'descripcion',
        'config',
        'activo',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'config' => 'array',
        'activo' => 'boolean',
    ];

    public function webhookEvents(): HasMany
    {
        return $this->hasMany(WebhookEvent::class, 'integration_id');
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(NotificationLog::class, 'integration_id');
    }

    public function externalMessages(): HasMany
    {
        return $this->hasMany(ExternalMessage::class, 'integration_id');
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
