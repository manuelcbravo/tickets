<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTicketPrioridad extends Model
{
    protected $table = 'cat_ticket_prioridades';

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
