<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTicketEstado extends Model
{
    protected $table = 'cat_ticket_estados';

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
