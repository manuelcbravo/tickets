<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTicketTipo extends Model
{
    protected $table = 'cat_ticket_tipos';

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
