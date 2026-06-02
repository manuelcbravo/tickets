<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repositorio extends Model
{
    use HasUuid, SoftDeletes;

    public const PROVEEDORES = ['github', 'gitlab', 'bitbucket', 'azure', 'otro'];

    protected $fillable = [
        'proyecto_id',
        'nombre',
        'proveedor',
        'url',
        'rama_principal',
        'descripcion',
        'activo',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(TicketDevelopmentTask::class, 'repositorio_id');
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
