<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProyectoPagoDocumento extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'proyecto_pago_documentos';

    protected $fillable = [
        'pago_id',
        'uploaded_by_id',
        'nombre_original',
        'ruta',
        'disk',
        'mime_type',
        'size',
        'descripcion',
    ];

    protected $appends = ['url'];

    public function pago(): BelongsTo
    {
        return $this->belongsTo(ProyectoPago::class, 'pago_id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->ruta);
    }
}
