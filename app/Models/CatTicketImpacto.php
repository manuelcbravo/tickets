<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTicketImpacto extends Model
{
    protected $table = 'cat_ticket_impactos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
