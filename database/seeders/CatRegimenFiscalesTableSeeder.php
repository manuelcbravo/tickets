<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatRegimenFiscalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_regimen_fiscales')->delete();
        
        \DB::table('cat_regimen_fiscales')->insert(array (
            0 => 
            array (
                'id' => 603,
                'nombre' => 'Personas Morales con Fines no Lucrativos',
            ),
            1 => 
            array (
                'id' => 605,
                'nombre' => 'Sueldos y Salarios e Ingresos Asimilados a Salarios',
            ),
            2 => 
            array (
                'id' => 606,
                'nombre' => 'Arrendamiento',
            ),
            3 => 
            array (
                'id' => 607,
                'nombre' => 'Régimen de Enajenación o Adquisición de Bienes',
            ),
            4 => 
            array (
                'id' => 608,
                'nombre' => 'Demás ingresos',
            ),
            5 => 
            array (
                'id' => 609,
                'nombre' => 'Consolidación',
            ),
            6 => 
            array (
                'id' => 610,
                'nombre' => 'Residentes en el Extranjero sin Establecimiento Permanente en México',
            ),
            7 => 
            array (
                'id' => 611,
                'nombre' => 'Ingresos por Dividendos',
            ),
            8 => 
            array (
                'id' => 612,
                'nombre' => 'Personas Físicas con Actividades Empresariales y Profesionales',
            ),
            9 => 
            array (
                'id' => 614,
                'nombre' => 'Ingresos por intereses',
            ),
            10 => 
            array (
                'id' => 615,
                'nombre' => 'Régimen de los ingresos por obtención de premios',
            ),
            11 => 
            array (
                'id' => 616,
                'nombre' => 'Sin obligaciones fiscales',
            ),
            12 => 
            array (
                'id' => 620,
                'nombre' => 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos',
            ),
            13 => 
            array (
                'id' => 621,
                'nombre' => 'Incorporación Fiscal',
            ),
            14 => 
            array (
                'id' => 622,
                'nombre' => 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',
            ),
            15 => 
            array (
                'id' => 623,
                'nombre' => 'Opcional para Grupos de Sociedades',
            ),
            16 => 
            array (
                'id' => 624,
                'nombre' => 'Coordinados',
            ),
            17 => 
            array (
                'id' => 628,
                'nombre' => 'Hidrocarburos',
            ),
            18 => 
            array (
                'id' => 629,
                'nombre' => 'De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales',
            ),
            19 => 
            array (
                'id' => 630,
                'nombre' => 'Enajenación de acciones en bolsa de valores',
            ),
            20 => 
            array (
                'id' => 601,
                'nombre' => 'General de Ley Personas Morales',
            ),
            21 => 
            array (
                'id' => 625,
                'nombre' => 'Regimen de las actividades Empresariales con Ingresos A travez de Plataformas Digitales',
            ),
            22 => 
            array (
                'id' => 626,
                'nombre' => 'Regimen Simplificado de Confianza',
            ),
        ));
        
        
    }
}