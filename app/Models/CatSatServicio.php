<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatSatServicio extends Model
{
    protected $table = 'cat_sat_servicios';

    protected $fillable = [
        'clave',
        'nombre',
    ];
}
