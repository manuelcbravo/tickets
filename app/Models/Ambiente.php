<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ambiente extends Model
{
    use HasUuid, SoftDeletes;

    public const NOMBRES = ['Produccion', 'Staging', 'Demo', 'Local', 'QA'];

    protected $table = 'environments';

    protected $fillable = [
        'project_id',
        'nombre',
        'url',
        'servidor',
        'rama',
        'notas',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'project_id');
    }

    public function releases(): HasMany
    {
        return $this->hasMany(Release::class, 'ambiente_id');
    }
}
