<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatSatClaveUnidadesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_sat_clave_unidades')->delete();
        
        \DB::table('cat_sat_clave_unidades')->insert(array (
            0 => 
            array (
                'id' => 1,
                'clave' => 'E48',
                'nombre' => 'Unidad de servicio',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}