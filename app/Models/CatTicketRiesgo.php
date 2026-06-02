<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTicketRiesgo extends Model
{
    protected $table = 'cat_ticket_riesgos';

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
