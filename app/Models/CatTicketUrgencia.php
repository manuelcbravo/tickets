<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTicketUrgencia extends Model
{
    protected $table = 'cat_ticket_urgencias';

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
