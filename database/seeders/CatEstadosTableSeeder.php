<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatEstadosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_estados')->delete();
        
        \DB::table('cat_estados')->insert(array (
            0 => 
            array (
                'id' => 1,
                'estado' => 'AGUASCALIENTES',
                'siglas' => 'AGS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'estado' => 'BAJA CALIFORNIA',
                'siglas' => 'BC',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'estado' => 'BAJA CALIFORNIA SUR',
                'siglas' => 'BCS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'estado' => 'CAMPECHE',
                'siglas' => 'CAMP',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 7,
                'estado' => 'CHIAPAS',
                'siglas' => 'CHIS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 8,
                'estado' => 'CHIHUAHUA',
                'siglas' => 'CHIH',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 5,
                'estado' => 'COAHUILA DE ZARAGOZA',
                'siglas' => 'COAH',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 6,
                'estado' => 'COLIMA',
                'siglas' => 'COL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 10,
                'estado' => 'DURANGO',
                'siglas' => 'DGO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 11,
                'estado' => 'GUANAJUATO',
                'siglas' => 'GTO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 12,
                'estado' => 'GUERRERO',
                'siglas' => 'GRO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 13,
                'estado' => 'HIDALGO',
                'siglas' => 'HGO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 14,
                'estado' => 'JALISCO',
                'siglas' => 'JAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 15,
                'estado' => 'MEXICO',
                'siglas' => 'MEX',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 16,
                'estado' => 'MICHOACAN DE OCAMPO',
                'siglas' => 'MICH',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 17,
                'estado' => 'MORELOS',
                'siglas' => 'MOR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 18,
                'estado' => 'NAYARIT',
                'siglas' => 'NAY',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 19,
                'estado' => 'NUEVO LEON',
                'siglas' => 'NL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 20,
                'estado' => 'OAXACA',
                'siglas' => 'OAX',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 21,
                'estado' => 'PUEBLA',
                'siglas' => 'PUE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 22,
                'estado' => 'QUERETARO',
                'siglas' => 'QRO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 23,
                'estado' => 'QUINTANA ROO',
                'siglas' => 'QR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 24,
                'estado' => 'SAN LUIS POTOSI',
                'siglas' => 'SLP',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 25,
                'estado' => 'SINALOA',
                'siglas' => 'SIN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 26,
                'estado' => 'SONORA',
                'siglas' => 'SON',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 27,
                'estado' => 'TABASCO',
                'siglas' => 'TAB',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 28,
                'estado' => 'TAMAULIPAS',
                'siglas' => 'TAMPS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 29,
                'estado' => 'TLAXCALA',
                'siglas' => 'TLAX',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 30,
                'estado' => 'VERACRUZ DE IGNACIO DE LA LLAVE',
                'siglas' => 'VER',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 31,
                'estado' => 'YUCATAN',
                'siglas' => 'YUC',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 32,
                'estado' => 'ZACATECAS',
                'siglas' => 'ZAC',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 9,
                'estado' => 'CIUDAD DE MEXICO',
                'siglas' => 'CDMX',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}