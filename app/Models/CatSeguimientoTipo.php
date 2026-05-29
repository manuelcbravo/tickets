<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatSeguimientoTipo extends Model
{
    protected $table = 'cat_seguimiento_tipos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function seguimientos(): HasMany
    {
        return $this->hasMany(Seguimiento::class, 'tipo_id');
    }
}
