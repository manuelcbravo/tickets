<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatFormaPagoSatsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_forma_pago_sats')->delete();
        
        DB::table('cat_forma_pago_sats')->insert(array (
            0 => array (
                'nombre' => 'Efectivo',
                'id_sat' => '01',
                'efectivo' => true, // Única forma de pago en efectivo real
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => array (
                'nombre' => 'Cheque nominativo',
                'id_sat' => '02',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => array (
                'nombre' => 'Transferencia electrónica de fondos',
                'id_sat' => '03',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => array (
                'nombre' => 'Tarjeta de crédito',
                'id_sat' => '04',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => array (
                'nombre' => 'Monedero electrónico',
                'id_sat' => '05',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 => array (
                'nombre' => 'Dinero electrónico',
                'id_sat' => '06',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            6 => array (
                'nombre' => 'Vales de despensa',
                'id_sat' => '08',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            7 => array (
                'nombre' => 'Dación en pago',
                'id_sat' => '12',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            8 => array (
                'nombre' => 'Pago por subrogación',
                'id_sat' => '13',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            9 => array (
                'nombre' => 'Pago por consignación',
                'id_sat' => '14',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            10 => array (
                'nombre' => 'Condonación',
                'id_sat' => '15',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            11 => array (
                'nombre' => 'Compensación',
                'id_sat' => '17',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            12 => array (
                'nombre' => 'Novación',
                'id_sat' => '23',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            13 => array (
                'nombre' => 'Confusión',
                'id_sat' => '24',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            14 => array (
                'nombre' => 'Remisión de deuda',
                'id_sat' => '25',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            15 => array (
                'nombre' => 'Prescripción o caducidad',
                'id_sat' => '26',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            16 => array (
                'nombre' => 'A satisfacción del acreedor',
                'id_sat' => '27',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            17 => array (
                'nombre' => 'Tarjeta de débito',
                'id_sat' => '28',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            18 => array (
                'nombre' => 'Tarjeta de servicios',
                'id_sat' => '29',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            19 => array (
                'nombre' => 'Aplicación de anticipos',
                'id_sat' => '30',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            20 => array (
                'nombre' => 'Por definir',
                'id_sat' => '99',
                'efectivo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
    }
}