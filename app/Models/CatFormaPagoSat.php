<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatFormaPagoSat extends Model
{
    protected $table = 'cat_forma_pago_sats';

    protected $primaryKey = 'id_sat';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_sat',
        'nombre',
        'efectivo',
    ];

    protected function casts(): array
    {
        return [
            'efectivo' => 'boolean',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'forma_pago_sat_id', 'id_sat');
    }
}
