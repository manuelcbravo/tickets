<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatSatServiciosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_sat_servicios')->delete();
        
        \DB::table('cat_sat_servicios')->insert(array (
            0 => 
            array (
                'id' => 1,
                'clave' => '85122000',
                'nombre' => 'Servicios dentales',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'clave' => '85122001',
                'nombre' => 'Servicios de odontólogos',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'clave' => '85122002',
                'nombre' => 'Servicios de higienistas dentales',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'clave' => '85122003',
                'nombre' => 'Servicios de personal de apoyo odontológico',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'clave' => '85122004',
                'nombre' => 'Servicios de cirujanos orales',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'clave' => '85122005',
                'nombre' => 'Servicios de ortodoncia',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'clave' => '01010101',
                'nombre' => 'General',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}