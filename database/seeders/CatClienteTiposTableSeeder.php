<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatClienteTiposTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_cliente_tipos')->delete();
        
        \DB::table('cat_cliente_tipos')->insert(array (
            0 => 
            array (
                'id' => 1,
            'nombre' => 'Titular Fisica (Persona fisica)',
            ),
            1 => 
            array (
                'id' => 2,
            'nombre' => 'Titular Moral (Persona moral)',
            ),
            2 => 
            array (
                'id' => 0,
            'nombre' => 'Sin definir/sin factura',
            ),
        ));
        
        
    }
}