<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatSatClaveUnidade extends Model
{
    protected $table = 'cat_sat_clave_unidades';

    protected $fillable = [
        'clave',
        'nombre',
    ];
}
