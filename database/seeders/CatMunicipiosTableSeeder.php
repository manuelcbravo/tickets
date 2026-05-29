<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatMunicipiosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_municipios')->delete();
        
        \DB::table('cat_municipios')->insert(array (
            0 => 
            array (
                'id' => 47,
                'municipio' => 'PACHUCA DE SOTO',
                'id_estado' => 13,
                'latitud' => '20.127597',
                'longitud' => '-98.731807',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 1,
                'municipio' => 'ABASOLO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 1,
                'municipio' => 'ACATLAN',
                'id_estado' => 13,
                'latitud' => '20.1449201',
                'longitud' => '-98.4451239',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 2,
                'municipio' => 'ACAXOCHITLAN',
                'id_estado' => 13,
                'latitud' => '20.1567831',
                'longitud' => '-98.2126291',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 2,
                'municipio' => 'ACUÐA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 3,
                'municipio' => 'ACTOPAN',
                'id_estado' => 13,
                'latitud' => '20.2735557',
                'longitud' => '-98.9661665',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 4,
                'municipio' => 'AGUA BLANCA DE ITURBIDE',
                'id_estado' => 13,
                'latitud' => '20.3479505',
                'longitud' => '-98.3672483',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 3,
                'municipio' => 'ALLENDE',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 6,
                'municipio' => 'ALFAJAYUCAN',
                'id_estado' => 13,
                'latitud' => '20.4046327',
                'longitud' => '-99.359206',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 5,
                'municipio' => 'AJACUBA',
                'id_estado' => 13,
                'latitud' => '20.0926137',
                'longitud' => '-99.1386494',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 7,
                'municipio' => 'ALMOLOYA',
                'id_estado' => 13,
                'latitud' => '19.7035817',
                'longitud' => '-98.4205328',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 8,
                'municipio' => 'APAN',
                'id_estado' => 13,
                'latitud' => '19.7035817',
                'longitud' => '-98.4205328',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 9,
                'municipio' => 'ATITALAQUIA',
                'id_estado' => 13,
                'latitud' => '20.0528707',
                'longitud' => '-99.2338595',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 10,
                'municipio' => 'ATLAPEXCO',
                'id_estado' => 13,
                'latitud' => '21.0209921',
                'longitud' => '-98.5130267',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 11,
                'municipio' => 'ATOTONILCO EL GRANDE',
                'id_estado' => 13,
                'latitud' => '20.3415632',
                'longitud' => '-98.958177',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 12,
                'municipio' => 'ATOTONILCO DE TULA',
                'id_estado' => 13,
                'latitud' => '20.0082231',
                'longitud' => '-99.2393686',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 13,
                'municipio' => 'CALNALI',
                'id_estado' => 13,
                'latitud' => '20.8979292',
                'longitud' => '-98.6052243',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 14,
                'municipio' => 'CARDONAL',
                'id_estado' => 13,
                'latitud' => '20.6143225',
                'longitud' => '-99.1255017',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 15,
                'municipio' => 'CUAUTEPEC DE HINOJOSA',
                'id_estado' => 13,
                'latitud' => '20.0371333',
                'longitud' => '-98.3572208',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 16,
                'municipio' => 'CHAPANTONGO',
                'id_estado' => 13,
                'latitud' => '20.2885496',
                'longitud' => '-99.43274',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 17,
                'municipio' => 'CHAPULHUACAN',
                'id_estado' => 13,
                'latitud' => '21.1576943',
                'longitud' => '-98.9133275',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 18,
                'municipio' => 'CHILCUAUTLA',
                'id_estado' => 13,
                'latitud' => '20.3280362',
                'longitud' => '-99.3976715',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 19,
                'municipio' => 'EL ARENAL',
                'id_estado' => 13,
                'latitud' => '20.2253895',
                'longitud' => '-98.9512004',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 20,
                'municipio' => 'ELOXOCHITLAN',
                'id_estado' => 13,
                'latitud' => '20.7442297',
                'longitud' => '-98.8455805',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 1,
                'municipio' => 'AGUASCALIENTES',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 2,
                'municipio' => 'ASIENTOS',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 3,
                'municipio' => 'CALVILLO',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 4,
                'municipio' => 'COSIO',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 5,
                'municipio' => 'JESUS MARIA',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 6,
                'municipio' => 'PABELLON DE ARTEAGA',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 7,
                'municipio' => 'RINCON DE ROMOS',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 8,
                'municipio' => 'SAN JOSE DE GRACIA',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 9,
                'municipio' => 'TEPEZALA',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 10,
                'municipio' => 'SAN FRANCISCO DE LOS ROMO',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 11,
                'municipio' => 'EL LLANO',
                'id_estado' => 1,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 1,
                'municipio' => 'ENSENADA',
                'id_estado' => 2,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 2,
                'municipio' => 'MEXICALI',
                'id_estado' => 2,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 3,
                'municipio' => 'TECATE',
                'id_estado' => 2,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 4,
                'municipio' => 'TIJUANA',
                'id_estado' => 2,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 5,
                'municipio' => 'PLAYAS DE ROSARITO',
                'id_estado' => 2,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 1,
                'municipio' => 'COMONDU',
                'id_estado' => 3,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 2,
                'municipio' => 'MULEGE',
                'id_estado' => 3,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 3,
                'municipio' => 'LA PAZ',
                'id_estado' => 3,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 4,
                'municipio' => 'LOS CABOS',
                'id_estado' => 3,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 5,
                'municipio' => 'LORETO',
                'id_estado' => 3,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 1,
                'municipio' => 'CAMPECHE',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 2,
                'municipio' => 'CALKINI',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 3,
                'municipio' => 'CARMEN',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 4,
                'municipio' => 'CHAMPOTON',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 5,
                'municipio' => 'HECELCHAKAN',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 6,
                'municipio' => 'HOPELCHEN',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 7,
                'municipio' => 'PALIZADA',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 8,
                'municipio' => 'TENABO',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 9,
                'municipio' => 'ESCARCEGA',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 10,
                'municipio' => 'CANDELARIA',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 11,
                'municipio' => 'CALAKMUL',
                'id_estado' => 4,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 4,
                'municipio' => 'ARTEAGA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 5,
                'municipio' => 'CANDELA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 6,
                'municipio' => 'CASTAÐOS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 7,
                'municipio' => 'CUATROCIENEGAS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 8,
                'municipio' => 'ESCOBEDO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 9,
                'municipio' => 'FRANCISCO I. MADERO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 10,
                'municipio' => 'FRONTERA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 11,
                'municipio' => 'GENERAL CEPEDA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 12,
                'municipio' => 'GUERRERO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 13,
                'municipio' => 'HIDALGO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 14,
                'municipio' => 'JIMENEZ',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 15,
                'municipio' => 'JUAREZ',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 16,
                'municipio' => 'LAMADRID',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 17,
                'municipio' => 'MATAMOROS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 18,
                'municipio' => 'MONCLOVA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 19,
                'municipio' => 'MORELOS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 20,
                'municipio' => 'MUZQUIZ',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 21,
                'municipio' => 'NADADORES',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 22,
                'municipio' => 'NAVA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 23,
                'municipio' => 'OCAMPO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 24,
                'municipio' => 'PARRAS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 25,
                'municipio' => 'PIEDRAS NEGRAS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 26,
                'municipio' => 'PROGRESO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 27,
                'municipio' => 'RAMOS ARIZPE',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 28,
                'municipio' => 'SABINAS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 29,
                'municipio' => 'SACRAMENTO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 30,
                'municipio' => 'SALTILLO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 31,
                'municipio' => 'SAN BUENAVENTURA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 32,
                'municipio' => 'SAN JUAN DE SABINAS',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 33,
                'municipio' => 'SAN PEDRO',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 34,
                'municipio' => 'SIERRA MOJADA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 35,
                'municipio' => 'TORREON',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 36,
                'municipio' => 'VIESCA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 37,
                'municipio' => 'VILLA UNION',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 38,
                'municipio' => 'ZARAGOZA',
                'id_estado' => 5,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 1,
                'municipio' => 'COLIMA',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 2,
                'municipio' => 'COMALA',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 3,
                'municipio' => 'COQUIMATLAN',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 => 
            array (
                'id' => 4,
                'municipio' => 'CUAUHTEMOC',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 => 
            array (
                'id' => 5,
                'municipio' => 'VILLA DE ALVAREZ',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 => 
            array (
                'id' => 6,
                'municipio' => 'ARMERIA',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 => 
            array (
                'id' => 7,
                'municipio' => 'IXTLAHUACAN',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 => 
            array (
                'id' => 8,
                'municipio' => 'MANZANILLO',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 => 
            array (
                'id' => 9,
                'municipio' => 'MINATITLAN',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 => 
            array (
                'id' => 10,
                'municipio' => 'TECOMAN',
                'id_estado' => 6,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 => 
            array (
                'id' => 1,
                'municipio' => 'ACACOYAGUA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 => 
            array (
                'id' => 2,
                'municipio' => 'ACALA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 => 
            array (
                'id' => 3,
                'municipio' => 'ACAPETAHUA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 => 
            array (
                'id' => 4,
                'municipio' => 'ALTAMIRANO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 => 
            array (
                'id' => 5,
                'municipio' => 'AMATAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 => 
            array (
                'id' => 6,
                'municipio' => 'AMATENANGO DE LA FRONTERA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 => 
            array (
                'id' => 7,
                'municipio' => 'AMATENANGO DEL VALLE',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 => 
            array (
                'id' => 8,
                'municipio' => 'ANGEL ALBINO CORZO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 => 
            array (
                'id' => 9,
                'municipio' => 'ARRIAGA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 => 
            array (
                'id' => 10,
                'municipio' => 'BEJUCAL DE OCAMPO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 => 
            array (
                'id' => 11,
                'municipio' => 'BELLA VISTA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 => 
            array (
                'id' => 12,
                'municipio' => 'BERRIOZABAL',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 => 
            array (
                'id' => 13,
                'municipio' => 'BOCHIL',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            114 => 
            array (
                'id' => 14,
                'municipio' => 'EL BOSQUE',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            115 => 
            array (
                'id' => 15,
                'municipio' => 'CACAHOATAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            116 => 
            array (
                'id' => 16,
                'municipio' => 'CATAZAJA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            117 => 
            array (
                'id' => 17,
                'municipio' => 'CINTALAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            118 => 
            array (
                'id' => 18,
                'municipio' => 'COAPILLA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            119 => 
            array (
                'id' => 19,
                'municipio' => 'COMITAN DE DOMINGUEZ',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            120 => 
            array (
                'id' => 20,
                'municipio' => 'LA CONCORDIA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            121 => 
            array (
                'id' => 21,
                'municipio' => 'COPAINALA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            122 => 
            array (
                'id' => 22,
                'municipio' => 'CHALCHIHUITAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            123 => 
            array (
                'id' => 23,
                'municipio' => 'CHAMULA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            124 => 
            array (
                'id' => 24,
                'municipio' => 'CHANAL',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            125 => 
            array (
                'id' => 25,
                'municipio' => 'CHAPULTENANGO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            126 => 
            array (
                'id' => 26,
                'municipio' => 'CHENALHO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            127 => 
            array (
                'id' => 27,
                'municipio' => 'CHIAPA DE CORZO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            128 => 
            array (
                'id' => 28,
                'municipio' => 'CHIAPILLA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            129 => 
            array (
                'id' => 29,
                'municipio' => 'CHICOASEN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            130 => 
            array (
                'id' => 30,
                'municipio' => 'CHICOMUSELO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            131 => 
            array (
                'id' => 31,
                'municipio' => 'CHILON',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            132 => 
            array (
                'id' => 32,
                'municipio' => 'ESCUINTLA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            133 => 
            array (
                'id' => 33,
                'municipio' => 'FRANCISCO LEON',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            134 => 
            array (
                'id' => 34,
                'municipio' => 'FRONTERA COMALAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            135 => 
            array (
                'id' => 35,
                'municipio' => 'FRONTERA HIDALGO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            136 => 
            array (
                'id' => 36,
                'municipio' => 'LA GRANDEZA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            137 => 
            array (
                'id' => 37,
                'municipio' => 'HUEHUETAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            138 => 
            array (
                'id' => 38,
                'municipio' => 'HUITIUPAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            139 => 
            array (
                'id' => 39,
                'municipio' => 'HUIXTAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            140 => 
            array (
                'id' => 40,
                'municipio' => 'HUIXTLA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            141 => 
            array (
                'id' => 41,
                'municipio' => 'LA INDEPENDENCIA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            142 => 
            array (
                'id' => 42,
                'municipio' => 'IXHUATAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            143 => 
            array (
                'id' => 43,
                'municipio' => 'IXTACOMITAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            144 => 
            array (
                'id' => 44,
                'municipio' => 'IXTAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            145 => 
            array (
                'id' => 45,
                'municipio' => 'IXTAPANGAJOYA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            146 => 
            array (
                'id' => 46,
                'municipio' => 'JIQUIPILAS',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            147 => 
            array (
                'id' => 47,
                'municipio' => 'JITOTOL',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            148 => 
            array (
                'id' => 48,
                'municipio' => 'JUAREZ',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            149 => 
            array (
                'id' => 49,
                'municipio' => 'LARRAINZAR',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            150 => 
            array (
                'id' => 50,
                'municipio' => 'LA LIBERTAD',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            151 => 
            array (
                'id' => 51,
                'municipio' => 'MAPASTEPEC',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            152 => 
            array (
                'id' => 52,
                'municipio' => 'LAS MARGARITAS',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            153 => 
            array (
                'id' => 53,
                'municipio' => 'MAZAPA DE MADERO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            154 => 
            array (
                'id' => 54,
                'municipio' => 'MAZATAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            155 => 
            array (
                'id' => 55,
                'municipio' => 'METAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            156 => 
            array (
                'id' => 56,
                'municipio' => 'MITONTIC',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            157 => 
            array (
                'id' => 57,
                'municipio' => 'MOTOZINTLA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            158 => 
            array (
                'id' => 58,
                'municipio' => 'NICOLAS RUIZ',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            159 => 
            array (
                'id' => 59,
                'municipio' => 'OCOSINGO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            160 => 
            array (
                'id' => 60,
                'municipio' => 'OCOTEPEC',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            161 => 
            array (
                'id' => 61,
                'municipio' => 'OCOZOCOAUTLA DE ESPINOSA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            162 => 
            array (
                'id' => 62,
                'municipio' => 'OSTUACAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            163 => 
            array (
                'id' => 63,
                'municipio' => 'OSUMACINTA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            164 => 
            array (
                'id' => 64,
                'municipio' => 'OXCHUC',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            165 => 
            array (
                'id' => 65,
                'municipio' => 'PALENQUE',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            166 => 
            array (
                'id' => 66,
                'municipio' => 'PANTELHO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            167 => 
            array (
                'id' => 67,
                'municipio' => 'PANTEPEC',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            168 => 
            array (
                'id' => 68,
                'municipio' => 'PICHUCALCO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            169 => 
            array (
                'id' => 69,
                'municipio' => 'PIJIJIAPAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            170 => 
            array (
                'id' => 70,
                'municipio' => 'EL PORVENIR',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            171 => 
            array (
                'id' => 71,
                'municipio' => 'PUEBLO NUEVO SOLISTAHUACAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            172 => 
            array (
                'id' => 72,
                'municipio' => 'RAYON',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            173 => 
            array (
                'id' => 73,
                'municipio' => 'REFORMA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            174 => 
            array (
                'id' => 74,
                'municipio' => 'LAS ROSAS',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            175 => 
            array (
                'id' => 75,
                'municipio' => 'SABANILLA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            176 => 
            array (
                'id' => 76,
                'municipio' => 'SALTO DE AGUA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            177 => 
            array (
                'id' => 77,
                'municipio' => 'SAN CRISTOBAL DE LAS CASAS',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            178 => 
            array (
                'id' => 78,
                'municipio' => 'SAN FERNANDO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            179 => 
            array (
                'id' => 79,
                'municipio' => 'SAN JUAN CANCUC',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            180 => 
            array (
                'id' => 80,
                'municipio' => 'SAN LUCAS',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            181 => 
            array (
                'id' => 81,
                'municipio' => 'SILTEPEC',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            182 => 
            array (
                'id' => 82,
                'municipio' => 'SIMOJOVEL',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            183 => 
            array (
                'id' => 83,
                'municipio' => 'SITALA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            184 => 
            array (
                'id' => 84,
                'municipio' => 'SOCOLTENANGO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            185 => 
            array (
                'id' => 85,
                'municipio' => 'SOLOSUCHIAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            186 => 
            array (
                'id' => 86,
                'municipio' => 'SOYALO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            187 => 
            array (
                'id' => 87,
                'municipio' => 'SUCHIAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            188 => 
            array (
                'id' => 88,
                'municipio' => 'SUCHIATE',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            189 => 
            array (
                'id' => 89,
                'municipio' => 'SUNUAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            190 => 
            array (
                'id' => 90,
                'municipio' => 'TAPACHULA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            191 => 
            array (
                'id' => 91,
                'municipio' => 'TAPALAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            192 => 
            array (
                'id' => 92,
                'municipio' => 'TAPILULA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            193 => 
            array (
                'id' => 93,
                'municipio' => 'TECPATAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            194 => 
            array (
                'id' => 94,
                'municipio' => 'TENEJAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            195 => 
            array (
                'id' => 95,
                'municipio' => 'TEOPISCA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            196 => 
            array (
                'id' => 96,
                'municipio' => 'TILA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            197 => 
            array (
                'id' => 97,
                'municipio' => 'TONALA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            198 => 
            array (
                'id' => 98,
                'municipio' => 'TOTOLAPA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            199 => 
            array (
                'id' => 99,
                'municipio' => 'LA TRINITARIA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            200 => 
            array (
                'id' => 100,
                'municipio' => 'TUMBALA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            201 => 
            array (
                'id' => 101,
                'municipio' => 'TUXTLA CHICO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            202 => 
            array (
                'id' => 102,
                'municipio' => 'TUXTLA GUTIERREZ',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            203 => 
            array (
                'id' => 103,
                'municipio' => 'TUZANTAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            204 => 
            array (
                'id' => 104,
                'municipio' => 'TZIMOL',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            205 => 
            array (
                'id' => 105,
                'municipio' => 'UNION JUAREZ',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            206 => 
            array (
                'id' => 106,
                'municipio' => 'VENUSTIANO CARRANZA',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            207 => 
            array (
                'id' => 107,
                'municipio' => 'VILLACOMALTITLAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            208 => 
            array (
                'id' => 108,
                'municipio' => 'VILLA CORZO',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            209 => 
            array (
                'id' => 109,
                'municipio' => 'VILLAFLORES',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            210 => 
            array (
                'id' => 110,
                'municipio' => 'YAJALON',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            211 => 
            array (
                'id' => 111,
                'municipio' => 'ZINACANTAN',
                'id_estado' => 7,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            212 => 
            array (
                'id' => 1,
                'municipio' => 'AHUMADA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            213 => 
            array (
                'id' => 2,
                'municipio' => 'ALDAMA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            214 => 
            array (
                'id' => 3,
                'municipio' => 'ALLENDE',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            215 => 
            array (
                'id' => 4,
                'municipio' => 'AQUILES SERDAN',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            216 => 
            array (
                'id' => 5,
                'municipio' => 'ASCENSION',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            217 => 
            array (
                'id' => 6,
                'municipio' => 'BACHINIVA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            218 => 
            array (
                'id' => 7,
                'municipio' => 'BALLEZA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            219 => 
            array (
                'id' => 8,
                'municipio' => 'BATOPILAS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            220 => 
            array (
                'id' => 9,
                'municipio' => 'BOCOYNA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            221 => 
            array (
                'id' => 10,
                'municipio' => 'BUENAVENTURA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            222 => 
            array (
                'id' => 11,
                'municipio' => 'CAMARGO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            223 => 
            array (
                'id' => 12,
                'municipio' => 'CARICHI',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            224 => 
            array (
                'id' => 13,
                'municipio' => 'CASAS GRANDES',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            225 => 
            array (
                'id' => 14,
                'municipio' => 'CORONADO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            226 => 
            array (
                'id' => 15,
                'municipio' => 'COYAME DEL SOTOL',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            227 => 
            array (
                'id' => 16,
                'municipio' => 'LA CRUZ',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            228 => 
            array (
                'id' => 17,
                'municipio' => 'CUAUHTEMOC',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            229 => 
            array (
                'id' => 18,
                'municipio' => 'CUSIHUIRIACHI',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            230 => 
            array (
                'id' => 19,
                'municipio' => 'CHIHUAHUA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            231 => 
            array (
                'id' => 20,
                'municipio' => 'CHINIPAS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            232 => 
            array (
                'id' => 21,
                'municipio' => 'DELICIAS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            233 => 
            array (
                'id' => 22,
                'municipio' => 'DR. BELISARIO DOMINGUEZ',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            234 => 
            array (
                'id' => 23,
                'municipio' => 'GALEANA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            235 => 
            array (
                'id' => 24,
                'municipio' => 'SANTA ISABEL',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            236 => 
            array (
                'id' => 25,
                'municipio' => 'GOMEZ FARIAS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            237 => 
            array (
                'id' => 26,
                'municipio' => 'GRAN MORELOS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            238 => 
            array (
                'id' => 27,
                'municipio' => 'GUACHOCHI',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            239 => 
            array (
                'id' => 28,
                'municipio' => 'GUADALUPE',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            240 => 
            array (
                'id' => 29,
                'municipio' => 'GUADALUPE Y CALVO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            241 => 
            array (
                'id' => 30,
                'municipio' => 'GUAZAPARES',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            242 => 
            array (
                'id' => 31,
                'municipio' => 'GUERRERO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            243 => 
            array (
                'id' => 32,
                'municipio' => 'HIDALGO DEL PARRAL',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            244 => 
            array (
                'id' => 33,
                'municipio' => 'HUEJOTITAN',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            245 => 
            array (
                'id' => 34,
                'municipio' => 'IGNACIO ZARAGOZA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            246 => 
            array (
                'id' => 35,
                'municipio' => 'JANOS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            247 => 
            array (
                'id' => 36,
                'municipio' => 'JIMENEZ',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            248 => 
            array (
                'id' => 37,
                'municipio' => 'JUAREZ',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            249 => 
            array (
                'id' => 38,
                'municipio' => 'JULIMES',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            250 => 
            array (
                'id' => 39,
                'municipio' => 'LOPEZ',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            251 => 
            array (
                'id' => 40,
                'municipio' => 'MADERA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            252 => 
            array (
                'id' => 41,
                'municipio' => 'MAGUARICHI',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            253 => 
            array (
                'id' => 42,
                'municipio' => 'MANUEL BENAVIDES',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            254 => 
            array (
                'id' => 43,
                'municipio' => 'MATACHI',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            255 => 
            array (
                'id' => 44,
                'municipio' => 'MATAMOROS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            256 => 
            array (
                'id' => 45,
                'municipio' => 'MEOQUI',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            257 => 
            array (
                'id' => 46,
                'municipio' => 'MORELOS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            258 => 
            array (
                'id' => 47,
                'municipio' => 'MORIS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            259 => 
            array (
                'id' => 48,
                'municipio' => 'NAMIQUIPA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            260 => 
            array (
                'id' => 49,
                'municipio' => 'NONOAVA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            261 => 
            array (
                'id' => 50,
                'municipio' => 'NUEVO CASAS GRANDES',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            262 => 
            array (
                'id' => 51,
                'municipio' => 'OCAMPO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            263 => 
            array (
                'id' => 52,
                'municipio' => 'OJINAGA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            264 => 
            array (
                'id' => 53,
                'municipio' => 'PRAXEDIS G. GUERRERO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            265 => 
            array (
                'id' => 54,
                'municipio' => 'RIVA PALACIO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            266 => 
            array (
                'id' => 55,
                'municipio' => 'ROSALES',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            267 => 
            array (
                'id' => 56,
                'municipio' => 'ROSARIO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            268 => 
            array (
                'id' => 57,
                'municipio' => 'SAN FRANCISCO DE BORJA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            269 => 
            array (
                'id' => 58,
                'municipio' => 'SAN FRANCISCO DE CONCHOS',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            270 => 
            array (
                'id' => 59,
                'municipio' => 'SAN FRANCISCO DEL ORO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            271 => 
            array (
                'id' => 60,
                'municipio' => 'SANTA BARBARA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            272 => 
            array (
                'id' => 61,
                'municipio' => 'SATEVO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            273 => 
            array (
                'id' => 62,
                'municipio' => 'SAUCILLO',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            274 => 
            array (
                'id' => 63,
                'municipio' => 'TEMOSACHIC',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            275 => 
            array (
                'id' => 64,
                'municipio' => 'EL TULE',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            276 => 
            array (
                'id' => 65,
                'municipio' => 'URIQUE',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            277 => 
            array (
                'id' => 66,
                'municipio' => 'URUACHI',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            278 => 
            array (
                'id' => 67,
                'municipio' => 'VALLE DE ZARAGOZA',
                'id_estado' => 8,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            279 => 
            array (
                'id' => 2,
                'municipio' => 'AZCAPOTZALCO',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            280 => 
            array (
                'id' => 3,
                'municipio' => 'COYOACAN',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            281 => 
            array (
                'id' => 4,
                'municipio' => 'CUAJIMALPA DE MORELOS',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            282 => 
            array (
                'id' => 5,
                'municipio' => 'GUSTAVO A. MADERO',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            283 => 
            array (
                'id' => 6,
                'municipio' => 'IZTACALCO',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            284 => 
            array (
                'id' => 7,
                'municipio' => 'IZTAPALAPA',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            285 => 
            array (
                'id' => 8,
                'municipio' => 'LA MAGDALENA CONTRERAS',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            286 => 
            array (
                'id' => 9,
                'municipio' => 'MILPA ALTA',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            287 => 
            array (
                'id' => 10,
                'municipio' => 'ALVARO OBREGON',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            288 => 
            array (
                'id' => 11,
                'municipio' => 'TLAHUAC',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            289 => 
            array (
                'id' => 12,
                'municipio' => 'TLALPAN',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            290 => 
            array (
                'id' => 13,
                'municipio' => 'XOCHIMILCO',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            291 => 
            array (
                'id' => 14,
                'municipio' => 'BENITO JUAREZ',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            292 => 
            array (
                'id' => 15,
                'municipio' => 'CUAUHTEMOC',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            293 => 
            array (
                'id' => 16,
                'municipio' => 'MIGUEL HIDALGO',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            294 => 
            array (
                'id' => 17,
                'municipio' => 'VENUSTIANO CARRANZA',
                'id_estado' => 9,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            295 => 
            array (
                'id' => 1,
                'municipio' => 'CANATLAN',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            296 => 
            array (
                'id' => 2,
                'municipio' => 'CANELAS',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            297 => 
            array (
                'id' => 3,
                'municipio' => 'CONETO DE COMONFORT',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            298 => 
            array (
                'id' => 4,
                'municipio' => 'CUENCAME',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            299 => 
            array (
                'id' => 5,
                'municipio' => 'DURANGO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            300 => 
            array (
                'id' => 6,
                'municipio' => 'SIMON BOLIVAR',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            301 => 
            array (
                'id' => 7,
                'municipio' => 'GOMEZ PALACIO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            302 => 
            array (
                'id' => 8,
                'municipio' => 'GUADALUPE VICTORIA',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            303 => 
            array (
                'id' => 9,
                'municipio' => 'GUANACEVI',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            304 => 
            array (
                'id' => 10,
                'municipio' => 'HIDALGO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            305 => 
            array (
                'id' => 11,
                'municipio' => 'INDE',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            306 => 
            array (
                'id' => 12,
                'municipio' => 'LERDO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            307 => 
            array (
                'id' => 13,
                'municipio' => 'MAPIMI',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            308 => 
            array (
                'id' => 14,
                'municipio' => 'MEZQUITAL',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            309 => 
            array (
                'id' => 15,
                'municipio' => 'NAZAS',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            310 => 
            array (
                'id' => 16,
                'municipio' => 'NOMBRE DE DIOS',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            311 => 
            array (
                'id' => 17,
                'municipio' => 'NUEVO IDEAL',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            312 => 
            array (
                'id' => 18,
                'municipio' => 'OCAMPO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            313 => 
            array (
                'id' => 19,
                'municipio' => 'EL ORO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            314 => 
            array (
                'id' => 20,
                'municipio' => 'OTAEZ',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            315 => 
            array (
                'id' => 21,
                'municipio' => 'PANUCO DE CORONADO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            316 => 
            array (
                'id' => 22,
                'municipio' => 'PEÐON BLANCO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            317 => 
            array (
                'id' => 23,
                'municipio' => 'POANAS',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            318 => 
            array (
                'id' => 24,
                'municipio' => 'PUEBLO NUEVO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            319 => 
            array (
                'id' => 25,
                'municipio' => 'RODEO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            320 => 
            array (
                'id' => 26,
                'municipio' => 'SAN BERNARDO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            321 => 
            array (
                'id' => 27,
                'municipio' => 'SAN DIMAS',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            322 => 
            array (
                'id' => 28,
                'municipio' => 'SAN JUAN DE GUADALUPE',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            323 => 
            array (
                'id' => 29,
                'municipio' => 'SAN JUAN DEL RIO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            324 => 
            array (
                'id' => 30,
                'municipio' => 'SAN LUIS DEL CORDERO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            325 => 
            array (
                'id' => 31,
                'municipio' => 'SAN PEDRO DEL GALLO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            326 => 
            array (
                'id' => 32,
                'municipio' => 'SANTA CLARA',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            327 => 
            array (
                'id' => 33,
                'municipio' => 'SANTIAGO PAPASQUIARO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            328 => 
            array (
                'id' => 34,
                'municipio' => 'SUCHIL',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            329 => 
            array (
                'id' => 35,
                'municipio' => 'TAMAZULA',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            330 => 
            array (
                'id' => 36,
                'municipio' => 'TEPEHUANES',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            331 => 
            array (
                'id' => 37,
                'municipio' => 'TLAHUALILO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            332 => 
            array (
                'id' => 38,
                'municipio' => 'TOPIA',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            333 => 
            array (
                'id' => 39,
                'municipio' => 'VICENTE GUERRERO',
                'id_estado' => 10,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            334 => 
            array (
                'id' => 1,
                'municipio' => 'ABASOLO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            335 => 
            array (
                'id' => 2,
                'municipio' => 'ACAMBARO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            336 => 
            array (
                'id' => 3,
                'municipio' => 'SAN MIGUEL DE ALLENDE',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            337 => 
            array (
                'id' => 4,
                'municipio' => 'APASEO EL ALTO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            338 => 
            array (
                'id' => 5,
                'municipio' => 'APASEO EL GRANDE',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            339 => 
            array (
                'id' => 6,
                'municipio' => 'ATARJEA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            340 => 
            array (
                'id' => 7,
                'municipio' => 'CELAYA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            341 => 
            array (
                'id' => 8,
                'municipio' => 'MANUEL DOBLADO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            342 => 
            array (
                'id' => 9,
                'municipio' => 'COMONFORT',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            343 => 
            array (
                'id' => 10,
                'municipio' => 'CORONEO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            344 => 
            array (
                'id' => 11,
                'municipio' => 'CORTAZAR',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            345 => 
            array (
                'id' => 12,
                'municipio' => 'CUERAMARO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            346 => 
            array (
                'id' => 13,
                'municipio' => 'DOCTOR MORA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            347 => 
            array (
                'id' => 14,
                'municipio' => 'DOLORES HIDALGO CUNA DE LA INDEPENDENCIA NACIONAL',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            348 => 
            array (
                'id' => 15,
                'municipio' => 'GUANAJUATO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            349 => 
            array (
                'id' => 16,
                'municipio' => 'HUANIMARO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            350 => 
            array (
                'id' => 17,
                'municipio' => 'IRAPUATO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            351 => 
            array (
                'id' => 18,
                'municipio' => 'JARAL DEL PROGRESO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            352 => 
            array (
                'id' => 19,
                'municipio' => 'JERECUARO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            353 => 
            array (
                'id' => 20,
                'municipio' => 'LEON',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            354 => 
            array (
                'id' => 21,
                'municipio' => 'MOROLEON',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            355 => 
            array (
                'id' => 22,
                'municipio' => 'OCAMPO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            356 => 
            array (
                'id' => 23,
                'municipio' => 'PENJAMO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            357 => 
            array (
                'id' => 24,
                'municipio' => 'PUEBLO NUEVO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            358 => 
            array (
                'id' => 25,
                'municipio' => 'PURISIMA DEL RINCON',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            359 => 
            array (
                'id' => 26,
                'municipio' => 'ROMITA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            360 => 
            array (
                'id' => 27,
                'municipio' => 'SALAMANCA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            361 => 
            array (
                'id' => 28,
                'municipio' => 'SALVATIERRA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            362 => 
            array (
                'id' => 29,
                'municipio' => 'SAN DIEGO DE LA UNION',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            363 => 
            array (
                'id' => 30,
                'municipio' => 'SAN FELIPE',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            364 => 
            array (
                'id' => 31,
                'municipio' => 'SAN FRANCISCO DEL RINCON',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            365 => 
            array (
                'id' => 32,
                'municipio' => 'SAN JOSE ITURBIDE',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            366 => 
            array (
                'id' => 33,
                'municipio' => 'SAN LUIS DE LA PAZ',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            367 => 
            array (
                'id' => 34,
                'municipio' => 'SANTA CATARINA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            368 => 
            array (
                'id' => 35,
                'municipio' => 'SANTA CRUZ DE JUVENTINO ROSAS',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            369 => 
            array (
                'id' => 36,
                'municipio' => 'SANTIAGO MARAVATIO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            370 => 
            array (
                'id' => 37,
                'municipio' => 'SILAO DE LA VICTORIA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            371 => 
            array (
                'id' => 38,
                'municipio' => 'TARANDACUAO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            372 => 
            array (
                'id' => 39,
                'municipio' => 'TARIMORO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            373 => 
            array (
                'id' => 40,
                'municipio' => 'TIERRA BLANCA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            374 => 
            array (
                'id' => 41,
                'municipio' => 'URIANGATO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            375 => 
            array (
                'id' => 42,
                'municipio' => 'VALLE DE SANTIAGO',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            376 => 
            array (
                'id' => 43,
                'municipio' => 'VICTORIA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            377 => 
            array (
                'id' => 44,
                'municipio' => 'VILLAGRAN',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            378 => 
            array (
                'id' => 45,
                'municipio' => 'XICHU',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            379 => 
            array (
                'id' => 46,
                'municipio' => 'YURIRIA',
                'id_estado' => 11,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            380 => 
            array (
                'id' => 1,
                'municipio' => 'ACAPULCO DE JUAREZ',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            381 => 
            array (
                'id' => 2,
                'municipio' => 'AHUACUOTZINGO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            382 => 
            array (
                'id' => 3,
                'municipio' => 'AJUCHITLAN DEL PROGRESO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            383 => 
            array (
                'id' => 4,
                'municipio' => 'ALCOZAUCA DE GUERRERO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            384 => 
            array (
                'id' => 5,
                'municipio' => 'ALPOYECA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            385 => 
            array (
                'id' => 6,
                'municipio' => 'APAXTLA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            386 => 
            array (
                'id' => 7,
                'municipio' => 'ARCELIA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            387 => 
            array (
                'id' => 8,
                'municipio' => 'ATENANGO DEL RIO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            388 => 
            array (
                'id' => 9,
                'municipio' => 'ATLAMAJALCINGO DEL MONTE',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            389 => 
            array (
                'id' => 10,
                'municipio' => 'ATLIXTAC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            390 => 
            array (
                'id' => 11,
                'municipio' => 'ATOYAC DE ALVAREZ',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            391 => 
            array (
                'id' => 12,
                'municipio' => 'AYUTLA DE LOS LIBRES',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            392 => 
            array (
                'id' => 13,
                'municipio' => 'AZOYU',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            393 => 
            array (
                'id' => 14,
                'municipio' => 'BENITO JUAREZ',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            394 => 
            array (
                'id' => 15,
                'municipio' => 'BUENAVISTA DE CUELLAR',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            395 => 
            array (
                'id' => 16,
                'municipio' => 'COAHUAYUTLA DE JOSE MARIA IZAZAGA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            396 => 
            array (
                'id' => 17,
                'municipio' => 'COCULA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            397 => 
            array (
                'id' => 18,
                'municipio' => 'COPALA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            398 => 
            array (
                'id' => 19,
                'municipio' => 'COPALILLO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            399 => 
            array (
                'id' => 20,
                'municipio' => 'COPANATOYAC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            400 => 
            array (
                'id' => 21,
                'municipio' => 'COYUCA DE BENITEZ',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            401 => 
            array (
                'id' => 22,
                'municipio' => 'COYUCA DE CATALAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            402 => 
            array (
                'id' => 23,
                'municipio' => 'CUAJINICUILAPA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            403 => 
            array (
                'id' => 24,
                'municipio' => 'CUALAC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            404 => 
            array (
                'id' => 25,
                'municipio' => 'CUAUTEPEC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            405 => 
            array (
                'id' => 26,
                'municipio' => 'CUETZALA DEL PROGRESO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            406 => 
            array (
                'id' => 27,
                'municipio' => 'CUTZAMALA DE PINZON',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            407 => 
            array (
                'id' => 28,
                'municipio' => 'CHILAPA DE ALVAREZ',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            408 => 
            array (
                'id' => 29,
                'municipio' => 'CHILPANCINGO DE LOS BRAVO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            409 => 
            array (
                'id' => 30,
                'municipio' => 'EDUARDO NERI',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            410 => 
            array (
                'id' => 31,
                'municipio' => 'FLORENCIO VILLARREAL',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            411 => 
            array (
                'id' => 32,
                'municipio' => 'GENERAL CANUTO A. NERI',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            412 => 
            array (
                'id' => 33,
                'municipio' => 'GENERAL HELIODORO CASTILLO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            413 => 
            array (
                'id' => 34,
                'municipio' => 'HUAMUXTITLAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            414 => 
            array (
                'id' => 35,
                'municipio' => 'HUITZUCO DE LOS FIGUEROA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            415 => 
            array (
                'id' => 36,
                'municipio' => 'IGUALA DE LA INDEPENDENCIA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            416 => 
            array (
                'id' => 37,
                'municipio' => 'IGUALAPA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            417 => 
            array (
                'id' => 38,
                'municipio' => 'IXCATEOPAN DE CUAUHTEMOC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            418 => 
            array (
                'id' => 39,
                'municipio' => 'ZIHUATANEJO DE AZUETA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            419 => 
            array (
                'id' => 40,
                'municipio' => 'JUAN R. ESCUDERO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            420 => 
            array (
                'id' => 41,
                'municipio' => 'LEONARDO BRAVO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            421 => 
            array (
                'id' => 42,
                'municipio' => 'MALINALTEPEC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            422 => 
            array (
                'id' => 43,
                'municipio' => 'MARTIR DE CUILAPAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            423 => 
            array (
                'id' => 44,
                'municipio' => 'METLATONOC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            424 => 
            array (
                'id' => 45,
                'municipio' => 'MOCHITLAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            425 => 
            array (
                'id' => 46,
                'municipio' => 'OLINALA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            426 => 
            array (
                'id' => 47,
                'municipio' => 'OMETEPEC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            427 => 
            array (
                'id' => 48,
                'municipio' => 'PEDRO ASCENCIO ALQUISIRAS',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            428 => 
            array (
                'id' => 49,
                'municipio' => 'PETATLAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            429 => 
            array (
                'id' => 50,
                'municipio' => 'PILCAYA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            430 => 
            array (
                'id' => 51,
                'municipio' => 'PUNGARABATO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            431 => 
            array (
                'id' => 52,
                'municipio' => 'QUECHULTENANGO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            432 => 
            array (
                'id' => 53,
                'municipio' => 'SAN LUIS ACATLAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            433 => 
            array (
                'id' => 54,
                'municipio' => 'SAN MARCOS',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            434 => 
            array (
                'id' => 55,
                'municipio' => 'SAN MIGUEL TOTOLAPAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            435 => 
            array (
                'id' => 56,
                'municipio' => 'TAXCO DE ALARCON',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            436 => 
            array (
                'id' => 57,
                'municipio' => 'TECOANAPA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            437 => 
            array (
                'id' => 58,
                'municipio' => 'TECPAN DE GALEANA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            438 => 
            array (
                'id' => 59,
                'municipio' => 'TELOLOAPAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            439 => 
            array (
                'id' => 60,
                'municipio' => 'TEPECOACUILCO DE TRUJANO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            440 => 
            array (
                'id' => 61,
                'municipio' => 'TETIPAC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            441 => 
            array (
                'id' => 62,
                'municipio' => 'TIXTLA DE GUERRERO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            442 => 
            array (
                'id' => 63,
                'municipio' => 'TLACOACHISTLAHUACA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            443 => 
            array (
                'id' => 64,
                'municipio' => 'TLACOAPA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            444 => 
            array (
                'id' => 65,
                'municipio' => 'TLALCHAPA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            445 => 
            array (
                'id' => 66,
                'municipio' => 'TLALIXTAQUILLA DE MALDONADO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            446 => 
            array (
                'id' => 67,
                'municipio' => 'TLAPA DE COMONFORT',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            447 => 
            array (
                'id' => 68,
                'municipio' => 'TLAPEHUALA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            448 => 
            array (
                'id' => 69,
                'municipio' => 'LA UNION DE ISIDORO MONTES DE OCA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            449 => 
            array (
                'id' => 70,
                'municipio' => 'XALPATLAHUAC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            450 => 
            array (
                'id' => 71,
                'municipio' => 'XOCHIHUEHUETLAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            451 => 
            array (
                'id' => 72,
                'municipio' => 'XOCHISTLAHUACA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            452 => 
            array (
                'id' => 73,
                'municipio' => 'ZAPOTITLAN TABLAS',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            453 => 
            array (
                'id' => 74,
                'municipio' => 'ZIRANDARO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            454 => 
            array (
                'id' => 75,
                'municipio' => 'ZITLALA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            455 => 
            array (
                'id' => 76,
                'municipio' => 'ACATEPEC',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            456 => 
            array (
                'id' => 77,
                'municipio' => 'JOSE JOAQUIN DE HERRERA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            457 => 
            array (
                'id' => 78,
                'municipio' => 'ILIATENCO',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            458 => 
            array (
                'id' => 79,
                'municipio' => 'COCHOAPA EL GRANDE',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            459 => 
            array (
                'id' => 80,
                'municipio' => 'MARQUELIA',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            460 => 
            array (
                'id' => 81,
                'municipio' => 'JUCHITAN',
                'id_estado' => 12,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            461 => 
            array (
                'id' => 1,
                'municipio' => 'ACATIC',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            462 => 
            array (
                'id' => 2,
                'municipio' => 'ACATLAN DE JUAREZ',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            463 => 
            array (
                'id' => 3,
                'municipio' => 'AHUALULCO DE MERCADO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            464 => 
            array (
                'id' => 4,
                'municipio' => 'AMACUECA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            465 => 
            array (
                'id' => 5,
                'municipio' => 'AMATITAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            466 => 
            array (
                'id' => 6,
                'municipio' => 'AMECA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            467 => 
            array (
                'id' => 7,
                'municipio' => 'SAN JUANITO DE ESCOBEDO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            468 => 
            array (
                'id' => 8,
                'municipio' => 'ARANDAS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            469 => 
            array (
                'id' => 9,
                'municipio' => 'EL ARENAL',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            470 => 
            array (
                'id' => 10,
                'municipio' => 'ATEMAJAC DE BRIZUELA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            471 => 
            array (
                'id' => 11,
                'municipio' => 'ATENGO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            472 => 
            array (
                'id' => 12,
                'municipio' => 'ATENGUILLO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            473 => 
            array (
                'id' => 13,
                'municipio' => 'ATOTONILCO EL ALTO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            474 => 
            array (
                'id' => 14,
                'municipio' => 'ATOYAC',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            475 => 
            array (
                'id' => 15,
                'municipio' => 'AUTLAN DE NAVARRO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            476 => 
            array (
                'id' => 16,
                'municipio' => 'AYOTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            477 => 
            array (
                'id' => 17,
                'municipio' => 'AYUTLA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            478 => 
            array (
                'id' => 18,
                'municipio' => 'LA BARCA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            479 => 
            array (
                'id' => 19,
                'municipio' => 'BOLAÐOS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            480 => 
            array (
                'id' => 20,
                'municipio' => 'CABO CORRIENTES',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            481 => 
            array (
                'id' => 21,
                'municipio' => 'CASIMIRO CASTILLO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            482 => 
            array (
                'id' => 22,
                'municipio' => 'CIHUATLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            483 => 
            array (
                'id' => 23,
                'municipio' => 'ZAPOTLAN EL GRANDE',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            484 => 
            array (
                'id' => 24,
                'municipio' => 'SAN GABRIEL',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            485 => 
            array (
                'id' => 25,
                'municipio' => 'COCULA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            486 => 
            array (
                'id' => 26,
                'municipio' => 'COLOTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            487 => 
            array (
                'id' => 27,
                'municipio' => 'CONCEPCION DE BUENOS AIRES',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            488 => 
            array (
                'id' => 28,
                'municipio' => 'CUAUTITLAN DE GARCIA BARRAGAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            489 => 
            array (
                'id' => 29,
                'municipio' => 'CUAUTLA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            490 => 
            array (
                'id' => 30,
                'municipio' => 'CUQUIO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            491 => 
            array (
                'id' => 31,
                'municipio' => 'CHAPALA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            492 => 
            array (
                'id' => 32,
                'municipio' => 'CHIMALTITAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            493 => 
            array (
                'id' => 33,
                'municipio' => 'CHIQUILISTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            494 => 
            array (
                'id' => 34,
                'municipio' => 'DEGOLLADO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            495 => 
            array (
                'id' => 35,
                'municipio' => 'EJUTLA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            496 => 
            array (
                'id' => 36,
                'municipio' => 'ENCARNACION DE DIAZ',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            497 => 
            array (
                'id' => 37,
                'municipio' => 'ETZATLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            498 => 
            array (
                'id' => 38,
                'municipio' => 'GOMEZ FARIAS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            499 => 
            array (
                'id' => 39,
                'municipio' => 'EL GRULLO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        \DB::table('cat_municipios')->insert(array (
            0 => 
            array (
                'id' => 40,
                'municipio' => 'GUACHINANGO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 41,
                'municipio' => 'GUADALAJARA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 42,
                'municipio' => 'HOSTOTIPAQUILLO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 43,
                'municipio' => 'HUEJUCAR',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 44,
                'municipio' => 'HUEJUQUILLA EL ALTO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 45,
                'municipio' => 'LA HUERTA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 46,
                'municipio' => 'IXTLAHUACAN DE LOS MEMBRILLOS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 47,
                'municipio' => 'IXTLAHUACAN DEL RIO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 48,
                'municipio' => 'JALOSTOTITLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 49,
                'municipio' => 'JAMAY',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 50,
                'municipio' => 'JESUS MARIA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 51,
                'municipio' => 'JILOTLAN DE LOS DOLORES',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 52,
                'municipio' => 'JOCOTEPEC',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 53,
                'municipio' => 'JUANACATLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 54,
                'municipio' => 'JUCHITLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 55,
                'municipio' => 'LAGOS DE MORENO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 56,
                'municipio' => 'EL LIMON',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 57,
                'municipio' => 'MAGDALENA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 58,
                'municipio' => 'SANTA MARIA DEL ORO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 59,
                'municipio' => 'LA MANZANILLA DE LA PAZ',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 60,
                'municipio' => 'MASCOTA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 61,
                'municipio' => 'MAZAMITLA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 62,
                'municipio' => 'MEXTICACAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 63,
                'municipio' => 'MEZQUITIC',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 64,
                'municipio' => 'MIXTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 65,
                'municipio' => 'OCOTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 66,
                'municipio' => 'OJUELOS DE JALISCO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 67,
                'municipio' => 'PIHUAMO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 68,
                'municipio' => 'PONCITLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 69,
                'municipio' => 'PUERTO VALLARTA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 70,
                'municipio' => 'VILLA PURIFICACION',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 71,
                'municipio' => 'QUITUPAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 72,
                'municipio' => 'EL SALTO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 73,
                'municipio' => 'SAN CRISTOBAL DE LA BARRANCA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 74,
                'municipio' => 'SAN DIEGO DE ALEJANDRIA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 75,
                'municipio' => 'SAN JUAN DE LOS LAGOS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 76,
                'municipio' => 'SAN JULIAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 77,
                'municipio' => 'SAN MARCOS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 78,
                'municipio' => 'SAN MARTIN DE BOLAÐOS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 79,
                'municipio' => 'SAN MARTIN HIDALGO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 80,
                'municipio' => 'SAN MIGUEL EL ALTO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 81,
                'municipio' => 'SAN SEBASTIAN DEL OESTE',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 82,
                'municipio' => 'SANTA MARIA DE LOS ANGELES',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 83,
                'municipio' => 'SAYULA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 84,
                'municipio' => 'TALA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 85,
                'municipio' => 'TALPA DE ALLENDE',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 86,
                'municipio' => 'TAMAZULA DE GORDIANO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 87,
                'municipio' => 'TAPALPA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 88,
                'municipio' => 'TECALITLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 89,
                'municipio' => 'TECOLOTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 90,
                'municipio' => 'TECHALUTA DE MONTENEGRO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 91,
                'municipio' => 'TENAMAXTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 92,
                'municipio' => 'TEOCALTICHE',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 93,
                'municipio' => 'TEOCUITATLAN DE CORONA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 94,
                'municipio' => 'TEPATITLAN DE MORELOS',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 95,
                'municipio' => 'TEQUILA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 96,
                'municipio' => 'TEUCHITLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 97,
                'municipio' => 'TIZAPAN EL ALTO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 98,
                'municipio' => 'TLAJOMULCO DE ZUÐIGA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 99,
                'municipio' => 'SAN PEDRO TLAQUEPAQUE',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 100,
                'municipio' => 'TOLIMAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 101,
                'municipio' => 'TOMATLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 102,
                'municipio' => 'TONALA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 103,
                'municipio' => 'TONAYA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 104,
                'municipio' => 'TONILA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 105,
                'municipio' => 'TOTATICHE',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 106,
                'municipio' => 'TOTOTLAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 107,
                'municipio' => 'TUXCACUESCO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 108,
                'municipio' => 'TUXCUECA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 109,
                'municipio' => 'TUXPAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 110,
                'municipio' => 'UNION DE SAN ANTONIO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 111,
                'municipio' => 'UNION DE TULA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 112,
                'municipio' => 'VALLE DE GUADALUPE',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 113,
                'municipio' => 'VALLE DE JUAREZ',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 114,
                'municipio' => 'VILLA CORONA',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 115,
                'municipio' => 'VILLA GUERRERO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 116,
                'municipio' => 'VILLA HIDALGO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 117,
                'municipio' => 'CAÐADAS DE OBREGON',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 118,
                'municipio' => 'YAHUALICA DE GONZALEZ GALLO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 119,
                'municipio' => 'ZACOALCO DE TORRES',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 120,
                'municipio' => 'ZAPOPAN',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 121,
                'municipio' => 'ZAPOTILTIC',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 122,
                'municipio' => 'ZAPOTITLAN DE VADILLO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 123,
                'municipio' => 'ZAPOTLAN DEL REY',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 124,
                'municipio' => 'ZAPOTLANEJO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 125,
                'municipio' => 'SAN IGNACIO CERRO GORDO',
                'id_estado' => 14,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 1,
                'municipio' => 'ACAMBAY DE RUIZ CASTAÐEDA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 2,
                'municipio' => 'ACOLMAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 3,
                'municipio' => 'ACULCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 4,
                'municipio' => 'ALMOLOYA DE ALQUISIRAS',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 5,
                'municipio' => 'ALMOLOYA DE JUAREZ',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 6,
                'municipio' => 'ALMOLOYA DEL RIO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 7,
                'municipio' => 'AMANALCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 8,
                'municipio' => 'AMATEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 => 
            array (
                'id' => 9,
                'municipio' => 'AMECAMECA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 => 
            array (
                'id' => 10,
                'municipio' => 'APAXCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 => 
            array (
                'id' => 11,
                'municipio' => 'ATENCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 => 
            array (
                'id' => 12,
                'municipio' => 'ATIZAPAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 => 
            array (
                'id' => 13,
                'municipio' => 'ATIZAPAN DE ZARAGOZA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 => 
            array (
                'id' => 14,
                'municipio' => 'ATLACOMULCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 => 
            array (
                'id' => 15,
                'municipio' => 'ATLAUTLA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 => 
            array (
                'id' => 16,
                'municipio' => 'AXAPUSCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 => 
            array (
                'id' => 17,
                'municipio' => 'AYAPANGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 => 
            array (
                'id' => 18,
                'municipio' => 'CALIMAYA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 => 
            array (
                'id' => 19,
                'municipio' => 'CAPULHUAC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 => 
            array (
                'id' => 20,
                'municipio' => 'COACALCO DE BERRIOZABAL',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 => 
            array (
                'id' => 21,
                'municipio' => 'COATEPEC HARINAS',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 => 
            array (
                'id' => 22,
                'municipio' => 'COCOTITLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 => 
            array (
                'id' => 23,
                'municipio' => 'COYOTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 => 
            array (
                'id' => 24,
                'municipio' => 'CUAUTITLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 => 
            array (
                'id' => 25,
                'municipio' => 'CUAUTITLAN IZCALLI',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 => 
            array (
                'id' => 26,
                'municipio' => 'CHALCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 => 
            array (
                'id' => 27,
                'municipio' => 'CHAPA DE MOTA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 => 
            array (
                'id' => 28,
                'municipio' => 'CHAPULTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            114 => 
            array (
                'id' => 29,
                'municipio' => 'CHIAUTLA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            115 => 
            array (
                'id' => 30,
                'municipio' => 'CHICOLOAPAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            116 => 
            array (
                'id' => 31,
                'municipio' => 'CHICONCUAC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            117 => 
            array (
                'id' => 32,
                'municipio' => 'CHIMALHUACAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            118 => 
            array (
                'id' => 33,
                'municipio' => 'DONATO GUERRA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            119 => 
            array (
                'id' => 34,
                'municipio' => 'ECATEPEC DE MORELOS',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            120 => 
            array (
                'id' => 35,
                'municipio' => 'ECATZINGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            121 => 
            array (
                'id' => 36,
                'municipio' => 'HUEHUETOCA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            122 => 
            array (
                'id' => 37,
                'municipio' => 'HUEYPOXTLA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            123 => 
            array (
                'id' => 38,
                'municipio' => 'HUIXQUILUCAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            124 => 
            array (
                'id' => 39,
                'municipio' => 'ISIDRO FABELA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            125 => 
            array (
                'id' => 40,
                'municipio' => 'IXTAPALUCA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            126 => 
            array (
                'id' => 41,
                'municipio' => 'IXTAPAN DE LA SAL',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            127 => 
            array (
                'id' => 42,
                'municipio' => 'IXTAPAN DEL ORO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            128 => 
            array (
                'id' => 43,
                'municipio' => 'IXTLAHUACA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            129 => 
            array (
                'id' => 44,
                'municipio' => 'XALATLACO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            130 => 
            array (
                'id' => 45,
                'municipio' => 'JALTENCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            131 => 
            array (
                'id' => 46,
                'municipio' => 'JILOTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            132 => 
            array (
                'id' => 47,
                'municipio' => 'JILOTZINGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            133 => 
            array (
                'id' => 48,
                'municipio' => 'JIQUIPILCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            134 => 
            array (
                'id' => 49,
                'municipio' => 'JOCOTITLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            135 => 
            array (
                'id' => 50,
                'municipio' => 'JOQUICINGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            136 => 
            array (
                'id' => 51,
                'municipio' => 'JUCHITEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            137 => 
            array (
                'id' => 52,
                'municipio' => 'LERMA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            138 => 
            array (
                'id' => 53,
                'municipio' => 'MALINALCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            139 => 
            array (
                'id' => 54,
                'municipio' => 'MELCHOR OCAMPO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            140 => 
            array (
                'id' => 55,
                'municipio' => 'METEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            141 => 
            array (
                'id' => 56,
                'municipio' => 'MEXICALTZINGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            142 => 
            array (
                'id' => 57,
                'municipio' => 'MORELOS',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            143 => 
            array (
                'id' => 58,
                'municipio' => 'NAUCALPAN DE JUAREZ',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            144 => 
            array (
                'id' => 59,
                'municipio' => 'NEXTLALPAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            145 => 
            array (
                'id' => 60,
                'municipio' => 'NEZAHUALCOYOTL',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            146 => 
            array (
                'id' => 61,
                'municipio' => 'NICOLAS ROMERO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            147 => 
            array (
                'id' => 62,
                'municipio' => 'NOPALTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            148 => 
            array (
                'id' => 63,
                'municipio' => 'OCOYOACAC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            149 => 
            array (
                'id' => 64,
                'municipio' => 'OCUILAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            150 => 
            array (
                'id' => 65,
                'municipio' => 'EL ORO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            151 => 
            array (
                'id' => 66,
                'municipio' => 'OTUMBA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            152 => 
            array (
                'id' => 67,
                'municipio' => 'OTZOLOAPAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            153 => 
            array (
                'id' => 68,
                'municipio' => 'OTZOLOTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            154 => 
            array (
                'id' => 69,
                'municipio' => 'OZUMBA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            155 => 
            array (
                'id' => 70,
                'municipio' => 'PAPALOTLA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            156 => 
            array (
                'id' => 71,
                'municipio' => 'LA PAZ',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            157 => 
            array (
                'id' => 72,
                'municipio' => 'POLOTITLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            158 => 
            array (
                'id' => 73,
                'municipio' => 'RAYON',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            159 => 
            array (
                'id' => 74,
                'municipio' => 'SAN ANTONIO LA ISLA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            160 => 
            array (
                'id' => 75,
                'municipio' => 'SAN FELIPE DEL PROGRESO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            161 => 
            array (
                'id' => 76,
                'municipio' => 'SAN MARTIN DE LAS PIRAMIDES',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            162 => 
            array (
                'id' => 77,
                'municipio' => 'SAN MATEO ATENCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            163 => 
            array (
                'id' => 78,
                'municipio' => 'SAN SIMON DE GUERRERO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            164 => 
            array (
                'id' => 79,
                'municipio' => 'SANTO TOMAS',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            165 => 
            array (
                'id' => 80,
                'municipio' => 'SOYANIQUILPAN DE JUAREZ',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            166 => 
            array (
                'id' => 81,
                'municipio' => 'SULTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            167 => 
            array (
                'id' => 82,
                'municipio' => 'TECAMAC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            168 => 
            array (
                'id' => 83,
                'municipio' => 'TEJUPILCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            169 => 
            array (
                'id' => 84,
                'municipio' => 'TEMAMATLA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            170 => 
            array (
                'id' => 85,
                'municipio' => 'TEMASCALAPA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            171 => 
            array (
                'id' => 86,
                'municipio' => 'TEMASCALCINGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            172 => 
            array (
                'id' => 87,
                'municipio' => 'TEMASCALTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            173 => 
            array (
                'id' => 88,
                'municipio' => 'TEMOAYA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            174 => 
            array (
                'id' => 89,
                'municipio' => 'TENANCINGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            175 => 
            array (
                'id' => 90,
                'municipio' => 'TENANGO DEL AIRE',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            176 => 
            array (
                'id' => 91,
                'municipio' => 'TENANGO DEL VALLE',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            177 => 
            array (
                'id' => 92,
                'municipio' => 'TEOLOYUCAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            178 => 
            array (
                'id' => 93,
                'municipio' => 'TEOTIHUACAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            179 => 
            array (
                'id' => 94,
                'municipio' => 'TEPETLAOXTOC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            180 => 
            array (
                'id' => 95,
                'municipio' => 'TEPETLIXPA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            181 => 
            array (
                'id' => 96,
                'municipio' => 'TEPOTZOTLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            182 => 
            array (
                'id' => 97,
                'municipio' => 'TEQUIXQUIAC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            183 => 
            array (
                'id' => 98,
                'municipio' => 'TEXCALTITLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            184 => 
            array (
                'id' => 99,
                'municipio' => 'TEXCALYACAC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            185 => 
            array (
                'id' => 100,
                'municipio' => 'TEXCOCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            186 => 
            array (
                'id' => 101,
                'municipio' => 'TEZOYUCA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            187 => 
            array (
                'id' => 102,
                'municipio' => 'TIANGUISTENCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            188 => 
            array (
                'id' => 103,
                'municipio' => 'TIMILPAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            189 => 
            array (
                'id' => 104,
                'municipio' => 'TLALMANALCO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            190 => 
            array (
                'id' => 105,
                'municipio' => 'TLALNEPANTLA DE BAZ',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            191 => 
            array (
                'id' => 106,
                'municipio' => 'TLATLAYA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            192 => 
            array (
                'id' => 107,
                'municipio' => 'TOLUCA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            193 => 
            array (
                'id' => 108,
                'municipio' => 'TONATICO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            194 => 
            array (
                'id' => 109,
                'municipio' => 'TULTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            195 => 
            array (
                'id' => 110,
                'municipio' => 'TULTITLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            196 => 
            array (
                'id' => 111,
                'municipio' => 'VALLE DE BRAVO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            197 => 
            array (
                'id' => 112,
                'municipio' => 'VILLA DE ALLENDE',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            198 => 
            array (
                'id' => 113,
                'municipio' => 'VILLA DEL CARBON',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            199 => 
            array (
                'id' => 114,
                'municipio' => 'VILLA GUERRERO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            200 => 
            array (
                'id' => 115,
                'municipio' => 'VILLA VICTORIA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            201 => 
            array (
                'id' => 116,
                'municipio' => 'XONACATLAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            202 => 
            array (
                'id' => 117,
                'municipio' => 'ZACAZONAPAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            203 => 
            array (
                'id' => 118,
                'municipio' => 'ZACUALPAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            204 => 
            array (
                'id' => 119,
                'municipio' => 'ZINACANTEPEC',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            205 => 
            array (
                'id' => 120,
                'municipio' => 'ZUMPAHUACAN',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            206 => 
            array (
                'id' => 121,
                'municipio' => 'ZUMPANGO',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            207 => 
            array (
                'id' => 122,
                'municipio' => 'VALLE DE CHALCO SOLIDARIDAD',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            208 => 
            array (
                'id' => 123,
                'municipio' => 'LUVIANOS',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            209 => 
            array (
                'id' => 124,
                'municipio' => 'SAN JOSE DEL RINCON',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            210 => 
            array (
                'id' => 125,
                'municipio' => 'TONANITLA',
                'id_estado' => 15,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            211 => 
            array (
                'id' => 1,
                'municipio' => 'ACUITZIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            212 => 
            array (
                'id' => 2,
                'municipio' => 'AGUILILLA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            213 => 
            array (
                'id' => 3,
                'municipio' => 'ALVARO OBREGON',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            214 => 
            array (
                'id' => 4,
                'municipio' => 'ANGAMACUTIRO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            215 => 
            array (
                'id' => 5,
                'municipio' => 'ANGANGUEO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            216 => 
            array (
                'id' => 6,
                'municipio' => 'APATZINGAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            217 => 
            array (
                'id' => 7,
                'municipio' => 'APORO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            218 => 
            array (
                'id' => 8,
                'municipio' => 'AQUILA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            219 => 
            array (
                'id' => 9,
                'municipio' => 'ARIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            220 => 
            array (
                'id' => 10,
                'municipio' => 'ARTEAGA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            221 => 
            array (
                'id' => 11,
                'municipio' => 'BRISEÐAS',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            222 => 
            array (
                'id' => 12,
                'municipio' => 'BUENAVISTA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            223 => 
            array (
                'id' => 13,
                'municipio' => 'CARACUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            224 => 
            array (
                'id' => 14,
                'municipio' => 'COAHUAYANA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            225 => 
            array (
                'id' => 15,
                'municipio' => 'COALCOMAN DE VAZQUEZ PALLARES',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            226 => 
            array (
                'id' => 16,
                'municipio' => 'COENEO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            227 => 
            array (
                'id' => 17,
                'municipio' => 'CONTEPEC',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            228 => 
            array (
                'id' => 18,
                'municipio' => 'COPANDARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            229 => 
            array (
                'id' => 19,
                'municipio' => 'COTIJA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            230 => 
            array (
                'id' => 20,
                'municipio' => 'CUITZEO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            231 => 
            array (
                'id' => 21,
                'municipio' => 'CHARAPAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            232 => 
            array (
                'id' => 22,
                'municipio' => 'CHARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            233 => 
            array (
                'id' => 23,
                'municipio' => 'CHAVINDA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            234 => 
            array (
                'id' => 24,
                'municipio' => 'CHERAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            235 => 
            array (
                'id' => 25,
                'municipio' => 'CHILCHOTA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            236 => 
            array (
                'id' => 26,
                'municipio' => 'CHINICUILA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            237 => 
            array (
                'id' => 27,
                'municipio' => 'CHUCANDIRO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            238 => 
            array (
                'id' => 28,
                'municipio' => 'CHURINTZIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            239 => 
            array (
                'id' => 29,
                'municipio' => 'CHURUMUCO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            240 => 
            array (
                'id' => 30,
                'municipio' => 'ECUANDUREO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            241 => 
            array (
                'id' => 31,
                'municipio' => 'EPITACIO HUERTA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            242 => 
            array (
                'id' => 32,
                'municipio' => 'ERONGARICUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            243 => 
            array (
                'id' => 33,
                'municipio' => 'GABRIEL ZAMORA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            244 => 
            array (
                'id' => 34,
                'municipio' => 'HIDALGO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            245 => 
            array (
                'id' => 35,
                'municipio' => 'LA HUACANA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            246 => 
            array (
                'id' => 36,
                'municipio' => 'HUANDACAREO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            247 => 
            array (
                'id' => 37,
                'municipio' => 'HUANIQUEO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            248 => 
            array (
                'id' => 38,
                'municipio' => 'HUETAMO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            249 => 
            array (
                'id' => 39,
                'municipio' => 'HUIRAMBA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            250 => 
            array (
                'id' => 40,
                'municipio' => 'INDAPARAPEO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            251 => 
            array (
                'id' => 41,
                'municipio' => 'IRIMBO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            252 => 
            array (
                'id' => 42,
                'municipio' => 'IXTLAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            253 => 
            array (
                'id' => 43,
                'municipio' => 'JACONA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            254 => 
            array (
                'id' => 44,
                'municipio' => 'JIMENEZ',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            255 => 
            array (
                'id' => 45,
                'municipio' => 'JIQUILPAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            256 => 
            array (
                'id' => 46,
                'municipio' => 'JOSE SIXTO VERDUZCO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            257 => 
            array (
                'id' => 47,
                'municipio' => 'JUAREZ',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            258 => 
            array (
                'id' => 48,
                'municipio' => 'JUNGAPEO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            259 => 
            array (
                'id' => 49,
                'municipio' => 'LAGUNILLAS',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            260 => 
            array (
                'id' => 50,
                'municipio' => 'LAZARO CARDENAS',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            261 => 
            array (
                'id' => 51,
                'municipio' => 'MADERO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            262 => 
            array (
                'id' => 52,
                'municipio' => 'MARAVATIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            263 => 
            array (
                'id' => 53,
                'municipio' => 'MARCOS CASTELLANOS',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            264 => 
            array (
                'id' => 54,
                'municipio' => 'MORELIA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            265 => 
            array (
                'id' => 55,
                'municipio' => 'MORELOS',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            266 => 
            array (
                'id' => 56,
                'municipio' => 'MUGICA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            267 => 
            array (
                'id' => 57,
                'municipio' => 'NAHUATZEN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            268 => 
            array (
                'id' => 58,
                'municipio' => 'NOCUPETARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            269 => 
            array (
                'id' => 59,
                'municipio' => 'NUEVO PARANGARICUTIRO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            270 => 
            array (
                'id' => 60,
                'municipio' => 'NUEVO URECHO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            271 => 
            array (
                'id' => 61,
                'municipio' => 'NUMARAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            272 => 
            array (
                'id' => 62,
                'municipio' => 'OCAMPO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            273 => 
            array (
                'id' => 63,
                'municipio' => 'PAJACUARAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            274 => 
            array (
                'id' => 64,
                'municipio' => 'PANINDICUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            275 => 
            array (
                'id' => 65,
                'municipio' => 'PARACUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            276 => 
            array (
                'id' => 66,
                'municipio' => 'PARACHO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            277 => 
            array (
                'id' => 67,
                'municipio' => 'PATZCUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            278 => 
            array (
                'id' => 68,
                'municipio' => 'PENJAMILLO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            279 => 
            array (
                'id' => 69,
                'municipio' => 'PERIBAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            280 => 
            array (
                'id' => 70,
                'municipio' => 'LA PIEDAD',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            281 => 
            array (
                'id' => 71,
                'municipio' => 'PUREPERO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            282 => 
            array (
                'id' => 72,
                'municipio' => 'PURUANDIRO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            283 => 
            array (
                'id' => 73,
                'municipio' => 'QUERENDARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            284 => 
            array (
                'id' => 74,
                'municipio' => 'QUIROGA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            285 => 
            array (
                'id' => 75,
                'municipio' => 'COJUMATLAN DE REGULES',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            286 => 
            array (
                'id' => 76,
                'municipio' => 'LOS REYES',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            287 => 
            array (
                'id' => 77,
                'municipio' => 'SAHUAYO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            288 => 
            array (
                'id' => 78,
                'municipio' => 'SAN LUCAS',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            289 => 
            array (
                'id' => 79,
                'municipio' => 'SANTA ANA MAYA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            290 => 
            array (
                'id' => 80,
                'municipio' => 'SALVADOR ESCALANTE',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            291 => 
            array (
                'id' => 81,
                'municipio' => 'SENGUIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            292 => 
            array (
                'id' => 82,
                'municipio' => 'SUSUPUATO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            293 => 
            array (
                'id' => 83,
                'municipio' => 'TACAMBARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            294 => 
            array (
                'id' => 84,
                'municipio' => 'TANCITARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            295 => 
            array (
                'id' => 85,
                'municipio' => 'TANGAMANDAPIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            296 => 
            array (
                'id' => 86,
                'municipio' => 'TANGANCICUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            297 => 
            array (
                'id' => 87,
                'municipio' => 'TANHUATO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            298 => 
            array (
                'id' => 88,
                'municipio' => 'TARETAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            299 => 
            array (
                'id' => 89,
                'municipio' => 'TARIMBARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            300 => 
            array (
                'id' => 90,
                'municipio' => 'TEPALCATEPEC',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            301 => 
            array (
                'id' => 91,
                'municipio' => 'TINGAMBATO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            302 => 
            array (
                'id' => 92,
                'municipio' => 'TING▄INDIN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            303 => 
            array (
                'id' => 93,
                'municipio' => 'TIQUICHEO DE NICOLAS ROMERO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            304 => 
            array (
                'id' => 94,
                'municipio' => 'TLALPUJAHUA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            305 => 
            array (
                'id' => 95,
                'municipio' => 'TLAZAZALCA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            306 => 
            array (
                'id' => 96,
                'municipio' => 'TOCUMBO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            307 => 
            array (
                'id' => 97,
                'municipio' => 'TUMBISCATIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            308 => 
            array (
                'id' => 98,
                'municipio' => 'TURICATO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            309 => 
            array (
                'id' => 99,
                'municipio' => 'TUXPAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            310 => 
            array (
                'id' => 100,
                'municipio' => 'TUZANTLA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            311 => 
            array (
                'id' => 101,
                'municipio' => 'TZINTZUNTZAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            312 => 
            array (
                'id' => 102,
                'municipio' => 'TZITZIO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            313 => 
            array (
                'id' => 103,
                'municipio' => 'URUAPAN',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            314 => 
            array (
                'id' => 104,
                'municipio' => 'VENUSTIANO CARRANZA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            315 => 
            array (
                'id' => 105,
                'municipio' => 'VILLAMAR',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            316 => 
            array (
                'id' => 106,
                'municipio' => 'VISTA HERMOSA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            317 => 
            array (
                'id' => 107,
                'municipio' => 'YURECUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            318 => 
            array (
                'id' => 108,
                'municipio' => 'ZACAPU',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            319 => 
            array (
                'id' => 109,
                'municipio' => 'ZAMORA',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            320 => 
            array (
                'id' => 110,
                'municipio' => 'ZINAPARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            321 => 
            array (
                'id' => 111,
                'municipio' => 'ZINAPECUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            322 => 
            array (
                'id' => 112,
                'municipio' => 'ZIRACUARETIRO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            323 => 
            array (
                'id' => 113,
                'municipio' => 'ZITACUARO',
                'id_estado' => 16,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            324 => 
            array (
                'id' => 1,
                'municipio' => 'AMACUZAC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            325 => 
            array (
                'id' => 2,
                'municipio' => 'ATLATLAHUCAN',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            326 => 
            array (
                'id' => 3,
                'municipio' => 'AXOCHIAPAN',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            327 => 
            array (
                'id' => 4,
                'municipio' => 'AYALA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            328 => 
            array (
                'id' => 5,
                'municipio' => 'COATLAN DEL RIO',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            329 => 
            array (
                'id' => 6,
                'municipio' => 'CUAUTLA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            330 => 
            array (
                'id' => 7,
                'municipio' => 'CUERNAVACA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            331 => 
            array (
                'id' => 8,
                'municipio' => 'EMILIANO ZAPATA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            332 => 
            array (
                'id' => 9,
                'municipio' => 'HUITZILAC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            333 => 
            array (
                'id' => 10,
                'municipio' => 'JANTETELCO',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            334 => 
            array (
                'id' => 11,
                'municipio' => 'JIUTEPEC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            335 => 
            array (
                'id' => 12,
                'municipio' => 'JOJUTLA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            336 => 
            array (
                'id' => 13,
                'municipio' => 'JONACATEPEC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            337 => 
            array (
                'id' => 14,
                'municipio' => 'MAZATEPEC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            338 => 
            array (
                'id' => 15,
                'municipio' => 'MIACATLAN',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            339 => 
            array (
                'id' => 16,
                'municipio' => 'OCUITUCO',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            340 => 
            array (
                'id' => 17,
                'municipio' => 'PUENTE DE IXTLA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            341 => 
            array (
                'id' => 18,
                'municipio' => 'TEMIXCO',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            342 => 
            array (
                'id' => 19,
                'municipio' => 'TEPALCINGO',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            343 => 
            array (
                'id' => 20,
                'municipio' => 'TEPOZTLAN',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            344 => 
            array (
                'id' => 21,
                'municipio' => 'TETECALA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            345 => 
            array (
                'id' => 22,
                'municipio' => 'TETELA DEL VOLCAN',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            346 => 
            array (
                'id' => 23,
                'municipio' => 'TLALNEPANTLA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            347 => 
            array (
                'id' => 24,
                'municipio' => 'TLALTIZAPAN DE ZAPATA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            348 => 
            array (
                'id' => 25,
                'municipio' => 'TLAQUILTENANGO',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            349 => 
            array (
                'id' => 26,
                'municipio' => 'TLAYACAPAN',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            350 => 
            array (
                'id' => 27,
                'municipio' => 'TOTOLAPAN',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            351 => 
            array (
                'id' => 28,
                'municipio' => 'XOCHITEPEC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            352 => 
            array (
                'id' => 29,
                'municipio' => 'YAUTEPEC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            353 => 
            array (
                'id' => 30,
                'municipio' => 'YECAPIXTLA',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            354 => 
            array (
                'id' => 31,
                'municipio' => 'ZACATEPEC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            355 => 
            array (
                'id' => 32,
                'municipio' => 'ZACUALPAN DE AMILPAS',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            356 => 
            array (
                'id' => 33,
                'municipio' => 'TEMOAC',
                'id_estado' => 17,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            357 => 
            array (
                'id' => 1,
                'municipio' => 'ACAPONETA',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            358 => 
            array (
                'id' => 2,
                'municipio' => 'AHUACATLAN',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            359 => 
            array (
                'id' => 3,
                'municipio' => 'AMATLAN DE CAÐAS',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            360 => 
            array (
                'id' => 4,
                'municipio' => 'BAHIA DE BANDERAS',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            361 => 
            array (
                'id' => 5,
                'municipio' => 'COMPOSTELA',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            362 => 
            array (
                'id' => 6,
                'municipio' => 'HUAJICORI',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            363 => 
            array (
                'id' => 7,
                'municipio' => 'IXTLAN DEL RIO',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            364 => 
            array (
                'id' => 8,
                'municipio' => 'JALA',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            365 => 
            array (
                'id' => 9,
                'municipio' => 'DEL NAYAR',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            366 => 
            array (
                'id' => 10,
                'municipio' => 'ROSAMORADA',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            367 => 
            array (
                'id' => 11,
                'municipio' => 'RUIZ',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            368 => 
            array (
                'id' => 12,
                'municipio' => 'SAN BLAS',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            369 => 
            array (
                'id' => 13,
                'municipio' => 'SAN PEDRO LAGUNILLAS',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            370 => 
            array (
                'id' => 14,
                'municipio' => 'SANTA MARIA DEL ORO',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            371 => 
            array (
                'id' => 15,
                'municipio' => 'SANTIAGO IXCUINTLA',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            372 => 
            array (
                'id' => 16,
                'municipio' => 'TECUALA',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            373 => 
            array (
                'id' => 17,
                'municipio' => 'TEPIC',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            374 => 
            array (
                'id' => 18,
                'municipio' => 'TUXPAN',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            375 => 
            array (
                'id' => 19,
                'municipio' => 'XALISCO',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            376 => 
            array (
                'id' => 20,
                'municipio' => 'LA YESCA',
                'id_estado' => 18,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            377 => 
            array (
                'id' => 1,
                'municipio' => 'ABASOLO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            378 => 
            array (
                'id' => 2,
                'municipio' => 'AGUALEGUAS',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            379 => 
            array (
                'id' => 3,
                'municipio' => 'LOS ALDAMAS',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            380 => 
            array (
                'id' => 4,
                'municipio' => 'ALLENDE',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            381 => 
            array (
                'id' => 5,
                'municipio' => 'ANAHUAC',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            382 => 
            array (
                'id' => 6,
                'municipio' => 'APODACA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            383 => 
            array (
                'id' => 7,
                'municipio' => 'ARAMBERRI',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            384 => 
            array (
                'id' => 8,
                'municipio' => 'BUSTAMANTE',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            385 => 
            array (
                'id' => 9,
                'municipio' => 'CADEREYTA JIMENEZ',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            386 => 
            array (
                'id' => 10,
                'municipio' => 'CARMEN',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            387 => 
            array (
                'id' => 11,
                'municipio' => 'CERRALVO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            388 => 
            array (
                'id' => 12,
                'municipio' => 'CIENEGA DE FLORES',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            389 => 
            array (
                'id' => 13,
                'municipio' => 'CHINA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            390 => 
            array (
                'id' => 14,
                'municipio' => 'DR. ARROYO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            391 => 
            array (
                'id' => 15,
                'municipio' => 'DR. COSS',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            392 => 
            array (
                'id' => 16,
                'municipio' => 'DR. GONZALEZ',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            393 => 
            array (
                'id' => 17,
                'municipio' => 'GALEANA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            394 => 
            array (
                'id' => 18,
                'municipio' => 'GARCIA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            395 => 
            array (
                'id' => 19,
                'municipio' => 'SAN PEDRO GARZA GARCIA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            396 => 
            array (
                'id' => 20,
                'municipio' => 'GRAL. BRAVO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            397 => 
            array (
                'id' => 21,
                'municipio' => 'GRAL. ESCOBEDO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            398 => 
            array (
                'id' => 22,
                'municipio' => 'GRAL. TERAN',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            399 => 
            array (
                'id' => 23,
                'municipio' => 'GRAL. TREVIÐO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            400 => 
            array (
                'id' => 24,
                'municipio' => 'GRAL. ZARAGOZA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            401 => 
            array (
                'id' => 25,
                'municipio' => 'GRAL. ZUAZUA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            402 => 
            array (
                'id' => 26,
                'municipio' => 'GUADALUPE',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            403 => 
            array (
                'id' => 27,
                'municipio' => 'LOS HERRERAS',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            404 => 
            array (
                'id' => 28,
                'municipio' => 'HIDALGO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            405 => 
            array (
                'id' => 29,
                'municipio' => 'HIGUERAS',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            406 => 
            array (
                'id' => 30,
                'municipio' => 'HUALAHUISES',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            407 => 
            array (
                'id' => 31,
                'municipio' => 'ITURBIDE',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            408 => 
            array (
                'id' => 32,
                'municipio' => 'JUAREZ',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            409 => 
            array (
                'id' => 33,
                'municipio' => 'LAMPAZOS DE NARANJO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            410 => 
            array (
                'id' => 34,
                'municipio' => 'LINARES',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            411 => 
            array (
                'id' => 35,
                'municipio' => 'MARIN',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            412 => 
            array (
                'id' => 36,
                'municipio' => 'MELCHOR OCAMPO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            413 => 
            array (
                'id' => 37,
                'municipio' => 'MIER Y NORIEGA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            414 => 
            array (
                'id' => 38,
                'municipio' => 'MINA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            415 => 
            array (
                'id' => 39,
                'municipio' => 'MONTEMORELOS',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            416 => 
            array (
                'id' => 40,
                'municipio' => 'MONTERREY',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            417 => 
            array (
                'id' => 41,
                'municipio' => 'PARAS',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            418 => 
            array (
                'id' => 42,
                'municipio' => 'PESQUERIA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            419 => 
            array (
                'id' => 43,
                'municipio' => 'LOS RAMONES',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            420 => 
            array (
                'id' => 44,
                'municipio' => 'RAYONES',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            421 => 
            array (
                'id' => 45,
                'municipio' => 'SABINAS HIDALGO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            422 => 
            array (
                'id' => 46,
                'municipio' => 'SALINAS VICTORIA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            423 => 
            array (
                'id' => 47,
                'municipio' => 'SAN NICOLAS DE LOS GARZA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            424 => 
            array (
                'id' => 48,
                'municipio' => 'SANTA CATARINA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            425 => 
            array (
                'id' => 49,
                'municipio' => 'SANTIAGO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            426 => 
            array (
                'id' => 50,
                'municipio' => 'VALLECILLO',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            427 => 
            array (
                'id' => 51,
                'municipio' => 'VILLALDAMA',
                'id_estado' => 19,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            428 => 
            array (
                'id' => 1,
                'municipio' => 'ABEJONES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            429 => 
            array (
                'id' => 2,
                'municipio' => 'ACATLAN DE PEREZ FIGUEROA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            430 => 
            array (
                'id' => 3,
                'municipio' => 'ANIMAS TRUJANO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            431 => 
            array (
                'id' => 4,
                'municipio' => 'ASUNCION CACALOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            432 => 
            array (
                'id' => 5,
                'municipio' => 'ASUNCION CUYOTEPEJI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            433 => 
            array (
                'id' => 6,
                'municipio' => 'ASUNCION IXTALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            434 => 
            array (
                'id' => 7,
                'municipio' => 'ASUNCION NOCHIXTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            435 => 
            array (
                'id' => 8,
                'municipio' => 'ASUNCION OCOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            436 => 
            array (
                'id' => 9,
                'municipio' => 'ASUNCION TLACOLULITA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            437 => 
            array (
                'id' => 10,
                'municipio' => 'AYOQUEZCO DE ALDAMA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            438 => 
            array (
                'id' => 11,
                'municipio' => 'AYOTZINTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            439 => 
            array (
                'id' => 12,
                'municipio' => 'EL BARRIO DE LA SOLEDAD',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            440 => 
            array (
                'id' => 13,
                'municipio' => 'CALIHUALA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            441 => 
            array (
                'id' => 14,
                'municipio' => 'CANDELARIA LOXICHA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            442 => 
            array (
                'id' => 15,
                'municipio' => 'CHAHUITES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            443 => 
            array (
                'id' => 16,
                'municipio' => 'CHALCATONGO DE HIDALGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            444 => 
            array (
                'id' => 17,
                'municipio' => 'CIENEGA DE ZIMATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            445 => 
            array (
                'id' => 18,
                'municipio' => 'COATECAS ALTAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            446 => 
            array (
                'id' => 19,
                'municipio' => 'COICOYAN DE LAS FLORES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            447 => 
            array (
                'id' => 20,
                'municipio' => 'LA COMPAÐIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            448 => 
            array (
                'id' => 21,
                'municipio' => 'CONCEPCION BUENAVISTA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            449 => 
            array (
                'id' => 22,
                'municipio' => 'CONCEPCION PAPALO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            450 => 
            array (
                'id' => 23,
                'municipio' => 'CONSTANCIA DEL ROSARIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            451 => 
            array (
                'id' => 24,
                'municipio' => 'COSOLAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            452 => 
            array (
                'id' => 25,
                'municipio' => 'COSOLTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            453 => 
            array (
                'id' => 26,
                'municipio' => 'CUILAPAM DE GUERRERO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            454 => 
            array (
                'id' => 27,
                'municipio' => 'CUYAMECALCO VILLA DE ZARAGOZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            455 => 
            array (
                'id' => 28,
                'municipio' => 'HEROICA CIUDAD DE EJUTLA DE CRESPO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            456 => 
            array (
                'id' => 29,
                'municipio' => 'ELOXOCHITLAN DE FLORES MAGON',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            457 => 
            array (
                'id' => 30,
                'municipio' => 'EL ESPINAL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            458 => 
            array (
                'id' => 31,
                'municipio' => 'FRESNILLO DE TRUJANO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            459 => 
            array (
                'id' => 32,
                'municipio' => 'GUADALUPE DE RAMIREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            460 => 
            array (
                'id' => 33,
                'municipio' => 'GUADALUPE ETLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            461 => 
            array (
                'id' => 34,
                'municipio' => 'GUELATAO DE JUAREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            462 => 
            array (
                'id' => 35,
                'municipio' => 'GUEVEA DE HUMBOLDT',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            463 => 
            array (
                'id' => 36,
                'municipio' => 'MESONES HIDALGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            464 => 
            array (
                'id' => 37,
                'municipio' => 'HEROICA CIUDAD DE HUAJUAPAN DE LEON',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            465 => 
            array (
                'id' => 38,
                'municipio' => 'HUAUTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            466 => 
            array (
                'id' => 39,
                'municipio' => 'HUAUTLA DE JIMENEZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            467 => 
            array (
                'id' => 40,
                'municipio' => 'IXPANTEPEC NIEVES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            468 => 
            array (
                'id' => 41,
                'municipio' => 'CIUDAD IXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            469 => 
            array (
                'id' => 42,
                'municipio' => 'IXTLAN DE JUAREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            470 => 
            array (
                'id' => 43,
                'municipio' => 'HEROICA CIUDAD DE JUCHITAN DE ZARAGOZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            471 => 
            array (
                'id' => 44,
                'municipio' => 'LOMA BONITA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            472 => 
            array (
                'id' => 45,
                'municipio' => 'MAGDALENA APASCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            473 => 
            array (
                'id' => 46,
                'municipio' => 'MAGDALENA JALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            474 => 
            array (
                'id' => 47,
                'municipio' => 'MAGDALENA MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            475 => 
            array (
                'id' => 48,
                'municipio' => 'MAGDALENA OCOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            476 => 
            array (
                'id' => 49,
                'municipio' => 'MAGDALENA PEÐASCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            477 => 
            array (
                'id' => 50,
                'municipio' => 'MAGDALENA TEITIPAC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            478 => 
            array (
                'id' => 51,
                'municipio' => 'MAGDALENA TEQUISISTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            479 => 
            array (
                'id' => 52,
                'municipio' => 'MAGDALENA TLACOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            480 => 
            array (
                'id' => 53,
                'municipio' => 'MAGDALENA YODOCONO DE PORFIRIO DIAZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            481 => 
            array (
                'id' => 54,
                'municipio' => 'MAGDALENA ZAHUATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            482 => 
            array (
                'id' => 55,
                'municipio' => 'MARISCALA DE JUAREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            483 => 
            array (
                'id' => 56,
                'municipio' => 'MARTIRES DE TACUBAYA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            484 => 
            array (
                'id' => 57,
                'municipio' => 'MATIAS ROMERO AVENDAÐO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            485 => 
            array (
                'id' => 58,
                'municipio' => 'MAZATLAN VILLA DE FLORES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            486 => 
            array (
                'id' => 59,
                'municipio' => 'MIAHUATLAN DE PORFIRIO DIAZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            487 => 
            array (
                'id' => 60,
                'municipio' => 'MIXISTLAN DE LA REFORMA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            488 => 
            array (
                'id' => 61,
                'municipio' => 'MONJAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            489 => 
            array (
                'id' => 62,
                'municipio' => 'NATIVIDAD',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            490 => 
            array (
                'id' => 63,
                'municipio' => 'NAZARENO ETLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            491 => 
            array (
                'id' => 64,
                'municipio' => 'NEJAPA DE MADERO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            492 => 
            array (
                'id' => 65,
                'municipio' => 'NUEVO ZOQUIAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            493 => 
            array (
                'id' => 66,
                'municipio' => 'OAXACA DE JUAREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            494 => 
            array (
                'id' => 67,
                'municipio' => 'OCOTLAN DE MORELOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            495 => 
            array (
                'id' => 68,
                'municipio' => 'LA PE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            496 => 
            array (
                'id' => 69,
                'municipio' => 'PINOTEPA DE DON LUIS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            497 => 
            array (
                'id' => 70,
                'municipio' => 'PLUMA HIDALGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            498 => 
            array (
                'id' => 71,
                'municipio' => 'PUTLA VILLA DE GUERRERO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            499 => 
            array (
                'id' => 72,
                'municipio' => 'REFORMA DE PINEDA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        \DB::table('cat_municipios')->insert(array (
            0 => 
            array (
                'id' => 73,
                'municipio' => 'LA REFORMA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 74,
                'municipio' => 'REYES ETLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 75,
                'municipio' => 'ROJAS DE CUAUHTEMOC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 76,
                'municipio' => 'SALINA CRUZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 77,
                'municipio' => 'SAN AGUSTIN AMATENGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 78,
                'municipio' => 'SAN AGUSTIN ATENANGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 79,
                'municipio' => 'SAN AGUSTIN CHAYUCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 80,
                'municipio' => 'SAN AGUSTIN DE LAS JUNTAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 81,
                'municipio' => 'SAN AGUSTIN ETLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 82,
                'municipio' => 'SAN AGUSTIN LOXICHA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 83,
                'municipio' => 'SAN AGUSTIN TLACOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 84,
                'municipio' => 'SAN AGUSTIN YATARENI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 85,
                'municipio' => 'SAN ANDRES CABECERA NUEVA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 86,
                'municipio' => 'SAN ANDRES DINICUITI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 87,
                'municipio' => 'SAN ANDRES HUAXPALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 88,
                'municipio' => 'SAN ANDRES HUAYAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 89,
                'municipio' => 'SAN ANDRES IXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 90,
                'municipio' => 'SAN ANDRES LAGUNAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 91,
                'municipio' => 'SAN ANDRES NUXIÐO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 92,
                'municipio' => 'SAN ANDRES PAXTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 93,
                'municipio' => 'SAN ANDRES SINAXTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 94,
                'municipio' => 'SAN ANDRES SOLAGA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 95,
                'municipio' => 'SAN ANDRES TEOTILALPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 96,
                'municipio' => 'SAN ANDRES TEPETLAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 97,
                'municipio' => 'SAN ANDRES YAA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 98,
                'municipio' => 'SAN ANDRES ZABACHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 99,
                'municipio' => 'SAN ANDRES ZAUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 100,
                'municipio' => 'SAN ANTONINO CASTILLO VELASCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 101,
                'municipio' => 'SAN ANTONINO EL ALTO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 102,
                'municipio' => 'SAN ANTONINO MONTE VERDE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 103,
                'municipio' => 'SAN ANTONIO ACUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 104,
                'municipio' => 'SAN ANTONIO DE LA CAL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 105,
                'municipio' => 'SAN ANTONIO HUITEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 106,
                'municipio' => 'SAN ANTONIO NANAHUATIPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 107,
                'municipio' => 'SAN ANTONIO SINICAHUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 108,
                'municipio' => 'SAN ANTONIO TEPETLAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 109,
                'municipio' => 'SAN BALTAZAR CHICHICAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 110,
                'municipio' => 'SAN BALTAZAR LOXICHA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 111,
                'municipio' => 'SAN BALTAZAR YATZACHI EL BAJO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 112,
                'municipio' => 'SAN BARTOLO COYOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 113,
                'municipio' => 'SAN BARTOLO SOYALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 114,
                'municipio' => 'SAN BARTOLO YAUTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 115,
                'municipio' => 'SAN BARTOLOME AYAUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 116,
                'municipio' => 'SAN BARTOLOME LOXICHA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 117,
                'municipio' => 'SAN BARTOLOME QUIALANA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 118,
                'municipio' => 'SAN BARTOLOME YUCUAÐE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 119,
                'municipio' => 'SAN BARTOLOME ZOOGOCHO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 120,
                'municipio' => 'SAN BERNARDO MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 121,
                'municipio' => 'SAN BLAS ATEMPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 122,
                'municipio' => 'SAN CARLOS YAUTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 123,
                'municipio' => 'SAN CRISTOBAL AMATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 124,
                'municipio' => 'SAN CRISTOBAL AMOLTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 125,
                'municipio' => 'SAN CRISTOBAL LACHIRIOAG',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 126,
                'municipio' => 'SAN CRISTOBAL SUCHIXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 127,
                'municipio' => 'SAN DIONISIO DEL MAR',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 128,
                'municipio' => 'SAN DIONISIO OCOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 129,
                'municipio' => 'SAN DIONISIO OCOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 130,
                'municipio' => 'SAN ESTEBAN ATATLAHUCA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 131,
                'municipio' => 'SAN FELIPE JALAPA DE DIAZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 132,
                'municipio' => 'SAN FELIPE TEJALAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 133,
                'municipio' => 'SAN FELIPE USILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 134,
                'municipio' => 'SAN FRANCISCO CAHUACUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 135,
                'municipio' => 'SAN FRANCISCO CAJONOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 136,
                'municipio' => 'SAN FRANCISCO CHAPULAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 137,
                'municipio' => 'SAN FRANCISCO CHINDUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 138,
                'municipio' => 'SAN FRANCISCO DEL MAR',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 139,
                'municipio' => 'SAN FRANCISCO HUEHUETLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 140,
                'municipio' => 'SAN FRANCISCO IXHUATAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 141,
                'municipio' => 'SAN FRANCISCO JALTEPETONGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 142,
                'municipio' => 'SAN FRANCISCO LACHIGOLO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 143,
                'municipio' => 'SAN FRANCISCO LOGUECHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 144,
                'municipio' => 'SAN FRANCISCO NUXAÐO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 145,
                'municipio' => 'SAN FRANCISCO OZOLOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 146,
                'municipio' => 'SAN FRANCISCO SOLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 147,
                'municipio' => 'SAN FRANCISCO TELIXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 148,
                'municipio' => 'SAN FRANCISCO TEOPAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 149,
                'municipio' => 'SAN FRANCISCO TLAPANCINGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 150,
                'municipio' => 'SAN GABRIEL MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 151,
                'municipio' => 'SAN ILDEFONSO AMATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 152,
                'municipio' => 'SAN ILDEFONSO SOLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 153,
                'municipio' => 'SAN ILDEFONSO VILLA ALTA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 154,
                'municipio' => 'SAN JACINTO AMILPAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 155,
                'municipio' => 'SAN JACINTO TLACOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 156,
                'municipio' => 'SAN JERONIMO COATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 157,
                'municipio' => 'SAN JERONIMO SILACAYOAPILLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 158,
                'municipio' => 'SAN JERONIMO SOSOLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 159,
                'municipio' => 'SAN JERONIMO TAVICHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 160,
                'municipio' => 'SAN JERONIMO TECOATL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 161,
                'municipio' => 'SAN JERONIMO TLACOCHAHUAYA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 162,
                'municipio' => 'SAN JORGE NUCHITA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 163,
                'municipio' => 'SAN JOSE AYUQUILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 164,
                'municipio' => 'SAN JOSE CHILTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 165,
                'municipio' => 'SAN JOSE DEL PEÐASCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 166,
                'municipio' => 'SAN JOSE ESTANCIA GRANDE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 => 
            array (
                'id' => 167,
                'municipio' => 'SAN JOSE INDEPENDENCIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 => 
            array (
                'id' => 168,
                'municipio' => 'SAN JOSE LACHIGUIRI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 => 
            array (
                'id' => 169,
                'municipio' => 'SAN JOSE DEL PROGRESO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 => 
            array (
                'id' => 170,
                'municipio' => 'SAN JOSE TENANGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 => 
            array (
                'id' => 171,
                'municipio' => 'SAN JUAN ACHIUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 => 
            array (
                'id' => 172,
                'municipio' => 'SAN JUAN ATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 => 
            array (
                'id' => 173,
                'municipio' => 'SAN JUAN BAUTISTA ATATLAHUCA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 => 
            array (
                'id' => 174,
                'municipio' => 'SAN JUAN BAUTISTA COIXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 => 
            array (
                'id' => 175,
                'municipio' => 'SAN JUAN BAUTISTA CUICATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 => 
            array (
                'id' => 176,
                'municipio' => 'SAN JUAN BAUTISTA GUELACHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 => 
            array (
                'id' => 177,
                'municipio' => 'SAN JUAN BAUTISTA JAYACATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 => 
            array (
                'id' => 178,
                'municipio' => 'SAN JUAN BAUTISTA LO DE SOTO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 => 
            array (
                'id' => 179,
                'municipio' => 'SAN JUAN BAUTISTA SUCHITEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 => 
            array (
                'id' => 180,
                'municipio' => 'SAN JUAN BAUTISTA TLACHICHILCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 => 
            array (
                'id' => 181,
                'municipio' => 'SAN JUAN BAUTISTA TLACOATZINTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 => 
            array (
                'id' => 182,
                'municipio' => 'SAN JUAN BAUTISTA TUXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 => 
            array (
                'id' => 183,
                'municipio' => 'SAN JUAN BAUTISTA VALLE NACIONAL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 => 
            array (
                'id' => 184,
                'municipio' => 'SAN JUAN CACAHUATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 => 
            array (
                'id' => 185,
                'municipio' => 'SAN JUAN CHICOMEZUCHIL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 => 
            array (
                'id' => 186,
                'municipio' => 'SAN JUAN CHILATECA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            114 => 
            array (
                'id' => 187,
                'municipio' => 'CHIQUIHUITLAN DE BENITO JUAREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            115 => 
            array (
                'id' => 188,
                'municipio' => 'SAN JUAN CIENEGUILLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            116 => 
            array (
                'id' => 189,
                'municipio' => 'SAN JUAN COATZOSPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            117 => 
            array (
                'id' => 190,
                'municipio' => 'SAN JUAN COLORADO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            118 => 
            array (
                'id' => 191,
                'municipio' => 'SAN JUAN COMALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            119 => 
            array (
                'id' => 192,
                'municipio' => 'SAN JUAN COTZOCON',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            120 => 
            array (
                'id' => 193,
                'municipio' => 'SAN JUAN DE LOS CUES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            121 => 
            array (
                'id' => 194,
                'municipio' => 'SAN JUAN DEL ESTADO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            122 => 
            array (
                'id' => 195,
                'municipio' => 'SAN JUAN DEL RIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            123 => 
            array (
                'id' => 196,
                'municipio' => 'SAN JUAN DIUXI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            124 => 
            array (
                'id' => 197,
                'municipio' => 'SAN JUAN EVANGELISTA ANALCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            125 => 
            array (
                'id' => 198,
                'municipio' => 'SAN JUAN GUELAVIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            126 => 
            array (
                'id' => 199,
                'municipio' => 'SAN JUAN GUICHICOVI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            127 => 
            array (
                'id' => 200,
                'municipio' => 'SAN JUAN IHUALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            128 => 
            array (
                'id' => 201,
                'municipio' => 'SAN JUAN JUQUILA MIXES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            129 => 
            array (
                'id' => 202,
                'municipio' => 'SAN JUAN JUQUILA VIJANOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            130 => 
            array (
                'id' => 203,
                'municipio' => 'SAN JUAN LACHAO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            131 => 
            array (
                'id' => 204,
                'municipio' => 'SAN JUAN LACHIGALLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            132 => 
            array (
                'id' => 205,
                'municipio' => 'SAN JUAN LAJARCIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            133 => 
            array (
                'id' => 206,
                'municipio' => 'SAN JUAN LALANA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            134 => 
            array (
                'id' => 207,
                'municipio' => 'SAN JUAN MAZATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            135 => 
            array (
                'id' => 208,
                'municipio' => 'SAN JUAN MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            136 => 
            array (
                'id' => 209,
                'municipio' => 'SAN JUAN MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            137 => 
            array (
                'id' => 210,
                'municipio' => 'SAN JUAN ÐUMI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            138 => 
            array (
                'id' => 211,
                'municipio' => 'SAN JUAN OZOLOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            139 => 
            array (
                'id' => 212,
                'municipio' => 'SAN JUAN PETLAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            140 => 
            array (
                'id' => 213,
                'municipio' => 'SAN JUAN QUIAHIJE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            141 => 
            array (
                'id' => 214,
                'municipio' => 'SAN JUAN QUIOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            142 => 
            array (
                'id' => 215,
                'municipio' => 'SAN JUAN SAYULTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            143 => 
            array (
                'id' => 216,
                'municipio' => 'SAN JUAN TABAA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            144 => 
            array (
                'id' => 217,
                'municipio' => 'SAN JUAN TAMAZOLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            145 => 
            array (
                'id' => 218,
                'municipio' => 'SAN JUAN TEITA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            146 => 
            array (
                'id' => 219,
                'municipio' => 'SAN JUAN TEITIPAC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            147 => 
            array (
                'id' => 220,
                'municipio' => 'SAN JUAN TEPEUXILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            148 => 
            array (
                'id' => 221,
                'municipio' => 'SAN JUAN TEPOSCOLULA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            149 => 
            array (
                'id' => 222,
                'municipio' => 'SAN JUAN YAEE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            150 => 
            array (
                'id' => 223,
                'municipio' => 'SAN JUAN YATZONA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            151 => 
            array (
                'id' => 224,
                'municipio' => 'SAN JUAN YUCUITA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            152 => 
            array (
                'id' => 225,
                'municipio' => 'SAN LORENZO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            153 => 
            array (
                'id' => 226,
                'municipio' => 'SAN LORENZO ALBARRADAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            154 => 
            array (
                'id' => 227,
                'municipio' => 'SAN LORENZO CACAOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            155 => 
            array (
                'id' => 228,
                'municipio' => 'SAN LORENZO CUAUNECUILTITLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            156 => 
            array (
                'id' => 229,
                'municipio' => 'SAN LORENZO TEXMELUCAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            157 => 
            array (
                'id' => 230,
                'municipio' => 'SAN LORENZO VICTORIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            158 => 
            array (
                'id' => 231,
                'municipio' => 'SAN LUCAS CAMOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            159 => 
            array (
                'id' => 232,
                'municipio' => 'SAN LUCAS OJITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            160 => 
            array (
                'id' => 233,
                'municipio' => 'SAN LUCAS QUIAVINI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            161 => 
            array (
                'id' => 234,
                'municipio' => 'SAN LUCAS ZOQUIAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            162 => 
            array (
                'id' => 235,
                'municipio' => 'SAN LUIS AMATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            163 => 
            array (
                'id' => 236,
                'municipio' => 'SAN MARCIAL OZOLOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            164 => 
            array (
                'id' => 237,
                'municipio' => 'SAN MARCOS ARTEAGA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            165 => 
            array (
                'id' => 238,
                'municipio' => 'SAN MARTIN DE LOS CANSECOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            166 => 
            array (
                'id' => 239,
                'municipio' => 'SAN MARTIN HUAMELULPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            167 => 
            array (
                'id' => 240,
                'municipio' => 'SAN MARTIN ITUNYOSO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            168 => 
            array (
                'id' => 241,
                'municipio' => 'SAN MARTIN LACHILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            169 => 
            array (
                'id' => 242,
                'municipio' => 'SAN MARTIN PERAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            170 => 
            array (
                'id' => 243,
                'municipio' => 'SAN MARTIN TILCAJETE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            171 => 
            array (
                'id' => 244,
                'municipio' => 'SAN MARTIN TOXPALAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            172 => 
            array (
                'id' => 245,
                'municipio' => 'SAN MARTIN ZACATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            173 => 
            array (
                'id' => 246,
                'municipio' => 'SAN MATEO CAJONOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            174 => 
            array (
                'id' => 247,
                'municipio' => 'SAN MATEO DEL MAR',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            175 => 
            array (
                'id' => 248,
                'municipio' => 'SAN MATEO ETLATONGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            176 => 
            array (
                'id' => 249,
                'municipio' => 'SAN MATEO NEJAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            177 => 
            array (
                'id' => 250,
                'municipio' => 'SAN MATEO PEÐASCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            178 => 
            array (
                'id' => 251,
                'municipio' => 'SAN MATEO PIÐAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            179 => 
            array (
                'id' => 252,
                'municipio' => 'SAN MATEO RIO HONDO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            180 => 
            array (
                'id' => 253,
                'municipio' => 'SAN MATEO SINDIHUI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            181 => 
            array (
                'id' => 254,
                'municipio' => 'SAN MATEO TLAPILTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            182 => 
            array (
                'id' => 255,
                'municipio' => 'SAN MATEO YOLOXOCHITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            183 => 
            array (
                'id' => 256,
                'municipio' => 'SAN MELCHOR BETAZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            184 => 
            array (
                'id' => 257,
                'municipio' => 'SAN MIGUEL ACHIUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            185 => 
            array (
                'id' => 258,
                'municipio' => 'SAN MIGUEL AHUEHUETITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            186 => 
            array (
                'id' => 259,
                'municipio' => 'SAN MIGUEL ALOAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            187 => 
            array (
                'id' => 260,
                'municipio' => 'SAN MIGUEL AMATITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            188 => 
            array (
                'id' => 261,
                'municipio' => 'SAN MIGUEL AMATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            189 => 
            array (
                'id' => 262,
                'municipio' => 'SAN MIGUEL CHICAHUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            190 => 
            array (
                'id' => 263,
                'municipio' => 'SAN MIGUEL CHIMALAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            191 => 
            array (
                'id' => 264,
                'municipio' => 'SAN MIGUEL COATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            192 => 
            array (
                'id' => 265,
                'municipio' => 'SAN MIGUEL DEL PUERTO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            193 => 
            array (
                'id' => 266,
                'municipio' => 'SAN MIGUEL DEL RIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            194 => 
            array (
                'id' => 267,
                'municipio' => 'SAN MIGUEL EJUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            195 => 
            array (
                'id' => 268,
                'municipio' => 'SAN MIGUEL EL GRANDE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            196 => 
            array (
                'id' => 269,
                'municipio' => 'SAN MIGUEL HUAUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            197 => 
            array (
                'id' => 270,
                'municipio' => 'SAN MIGUEL MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            198 => 
            array (
                'id' => 271,
                'municipio' => 'SAN MIGUEL PANIXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            199 => 
            array (
                'id' => 272,
                'municipio' => 'SAN MIGUEL PERAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            200 => 
            array (
                'id' => 273,
                'municipio' => 'SAN MIGUEL PIEDRAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            201 => 
            array (
                'id' => 274,
                'municipio' => 'SAN MIGUEL QUETZALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            202 => 
            array (
                'id' => 275,
                'municipio' => 'SAN MIGUEL SANTA FLOR',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            203 => 
            array (
                'id' => 276,
                'municipio' => 'SAN MIGUEL SOYALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            204 => 
            array (
                'id' => 277,
                'municipio' => 'SAN MIGUEL SUCHIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            205 => 
            array (
                'id' => 278,
                'municipio' => 'VILLA TALEA DE CASTRO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            206 => 
            array (
                'id' => 279,
                'municipio' => 'SAN MIGUEL TECOMATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            207 => 
            array (
                'id' => 280,
                'municipio' => 'SAN MIGUEL TENANGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            208 => 
            array (
                'id' => 281,
                'municipio' => 'SAN MIGUEL TEQUIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            209 => 
            array (
                'id' => 282,
                'municipio' => 'SAN MIGUEL TILQUIAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            210 => 
            array (
                'id' => 283,
                'municipio' => 'SAN MIGUEL TLACAMAMA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            211 => 
            array (
                'id' => 284,
                'municipio' => 'SAN MIGUEL TLACOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            212 => 
            array (
                'id' => 285,
                'municipio' => 'SAN MIGUEL TULANCINGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            213 => 
            array (
                'id' => 286,
                'municipio' => 'SAN MIGUEL YOTAO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            214 => 
            array (
                'id' => 287,
                'municipio' => 'SAN NICOLAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            215 => 
            array (
                'id' => 288,
                'municipio' => 'SAN NICOLAS HIDALGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            216 => 
            array (
                'id' => 289,
                'municipio' => 'SAN PABLO COATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            217 => 
            array (
                'id' => 290,
                'municipio' => 'SAN PABLO CUATRO VENADOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            218 => 
            array (
                'id' => 291,
                'municipio' => 'SAN PABLO ETLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            219 => 
            array (
                'id' => 292,
                'municipio' => 'SAN PABLO HUITZO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            220 => 
            array (
                'id' => 293,
                'municipio' => 'SAN PABLO HUIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            221 => 
            array (
                'id' => 294,
                'municipio' => 'SAN PABLO MACUILTIANGUIS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            222 => 
            array (
                'id' => 295,
                'municipio' => 'SAN PABLO TIJALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            223 => 
            array (
                'id' => 296,
                'municipio' => 'SAN PABLO VILLA DE MITLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            224 => 
            array (
                'id' => 297,
                'municipio' => 'SAN PABLO YAGANIZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            225 => 
            array (
                'id' => 298,
                'municipio' => 'SAN PEDRO AMUZGOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            226 => 
            array (
                'id' => 299,
                'municipio' => 'SAN PEDRO APOSTOL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            227 => 
            array (
                'id' => 300,
                'municipio' => 'SAN PEDRO ATOYAC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            228 => 
            array (
                'id' => 301,
                'municipio' => 'SAN PEDRO CAJONOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            229 => 
            array (
                'id' => 302,
                'municipio' => 'SAN PEDRO COXCALTEPEC CANTAROS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            230 => 
            array (
                'id' => 303,
                'municipio' => 'SAN PEDRO COMITANCILLO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            231 => 
            array (
                'id' => 304,
                'municipio' => 'SAN PEDRO EL ALTO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            232 => 
            array (
                'id' => 305,
                'municipio' => 'SAN PEDRO HUAMELULA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            233 => 
            array (
                'id' => 306,
                'municipio' => 'SAN PEDRO HUILOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            234 => 
            array (
                'id' => 307,
                'municipio' => 'SAN PEDRO IXCATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            235 => 
            array (
                'id' => 308,
                'municipio' => 'SAN PEDRO IXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            236 => 
            array (
                'id' => 309,
                'municipio' => 'SAN PEDRO JALTEPETONGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            237 => 
            array (
                'id' => 310,
                'municipio' => 'SAN PEDRO JICAYAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            238 => 
            array (
                'id' => 311,
                'municipio' => 'SAN PEDRO JOCOTIPAC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            239 => 
            array (
                'id' => 312,
                'municipio' => 'SAN PEDRO JUCHATENGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            240 => 
            array (
                'id' => 313,
                'municipio' => 'SAN PEDRO MARTIR',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            241 => 
            array (
                'id' => 314,
                'municipio' => 'SAN PEDRO MARTIR QUIECHAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            242 => 
            array (
                'id' => 315,
                'municipio' => 'SAN PEDRO MARTIR YUCUXACO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            243 => 
            array (
                'id' => 316,
                'municipio' => 'SAN PEDRO MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            244 => 
            array (
                'id' => 317,
                'municipio' => 'SAN PEDRO MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            245 => 
            array (
                'id' => 318,
                'municipio' => 'SAN PEDRO MOLINOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            246 => 
            array (
                'id' => 319,
                'municipio' => 'SAN PEDRO NOPALA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            247 => 
            array (
                'id' => 320,
                'municipio' => 'SAN PEDRO OCOPETATILLO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            248 => 
            array (
                'id' => 321,
                'municipio' => 'SAN PEDRO OCOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            249 => 
            array (
                'id' => 322,
                'municipio' => 'SAN PEDRO POCHUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            250 => 
            array (
                'id' => 323,
                'municipio' => 'SAN PEDRO QUIATONI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            251 => 
            array (
                'id' => 324,
                'municipio' => 'SAN PEDRO SOCHIAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            252 => 
            array (
                'id' => 325,
                'municipio' => 'SAN PEDRO TAPANATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            253 => 
            array (
                'id' => 326,
                'municipio' => 'SAN PEDRO TAVICHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            254 => 
            array (
                'id' => 327,
                'municipio' => 'SAN PEDRO TEOZACOALCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            255 => 
            array (
                'id' => 328,
                'municipio' => 'SAN PEDRO TEUTILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            256 => 
            array (
                'id' => 329,
                'municipio' => 'SAN PEDRO TIDAA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            257 => 
            array (
                'id' => 330,
                'municipio' => 'SAN PEDRO TOPILTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            258 => 
            array (
                'id' => 331,
                'municipio' => 'SAN PEDRO TOTOLAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            259 => 
            array (
                'id' => 332,
                'municipio' => 'VILLA DE TUTUTEPEC DE MELCHOR OCAMPO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            260 => 
            array (
                'id' => 333,
                'municipio' => 'SAN PEDRO Y SAN PABLO AYUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            261 => 
            array (
                'id' => 334,
                'municipio' => 'SAN PEDRO Y SAN PABLO TEPOSCOLULA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            262 => 
            array (
                'id' => 335,
                'municipio' => 'SAN PEDRO Y SAN PABLO TEQUIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            263 => 
            array (
                'id' => 336,
                'municipio' => 'SAN PEDRO YANERI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            264 => 
            array (
                'id' => 337,
                'municipio' => 'SAN PEDRO YOLOX',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            265 => 
            array (
                'id' => 338,
                'municipio' => 'SAN PEDRO YUCUNAMA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            266 => 
            array (
                'id' => 339,
                'municipio' => 'SAN RAYMUNDO JALPAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            267 => 
            array (
                'id' => 340,
                'municipio' => 'SAN SEBASTIAN ABASOLO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            268 => 
            array (
                'id' => 341,
                'municipio' => 'SAN SEBASTIAN COATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            269 => 
            array (
                'id' => 342,
                'municipio' => 'SAN SEBASTIAN IXCAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            270 => 
            array (
                'id' => 343,
                'municipio' => 'SAN SEBASTIAN NICANANDUTA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            271 => 
            array (
                'id' => 344,
                'municipio' => 'SAN SEBASTIAN RIO HONDO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            272 => 
            array (
                'id' => 345,
                'municipio' => 'SAN SEBASTIAN TECOMAXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            273 => 
            array (
                'id' => 346,
                'municipio' => 'SAN SEBASTIAN TEITIPAC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            274 => 
            array (
                'id' => 347,
                'municipio' => 'SAN SEBASTIAN TUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            275 => 
            array (
                'id' => 348,
                'municipio' => 'SAN SIMON ALMOLONGAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            276 => 
            array (
                'id' => 349,
                'municipio' => 'SAN SIMON ZAHUATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            277 => 
            array (
                'id' => 350,
                'municipio' => 'SAN VICENTE COATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            278 => 
            array (
                'id' => 351,
                'municipio' => 'SAN VICENTE LACHIXIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            279 => 
            array (
                'id' => 352,
                'municipio' => 'SAN VICENTE NUÐU',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            280 => 
            array (
                'id' => 353,
                'municipio' => 'SANTA ANA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            281 => 
            array (
                'id' => 354,
                'municipio' => 'SANTA ANA ATEIXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            282 => 
            array (
                'id' => 355,
                'municipio' => 'SANTA ANA CUAUHTEMOC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            283 => 
            array (
                'id' => 356,
                'municipio' => 'SANTA ANA DEL VALLE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            284 => 
            array (
                'id' => 357,
                'municipio' => 'SANTA ANA TAVELA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            285 => 
            array (
                'id' => 358,
                'municipio' => 'SANTA ANA TLAPACOYAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            286 => 
            array (
                'id' => 359,
                'municipio' => 'SANTA ANA YARENI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            287 => 
            array (
                'id' => 360,
                'municipio' => 'SANTA ANA ZEGACHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            288 => 
            array (
                'id' => 361,
                'municipio' => 'SANTA CATALINA QUIERI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            289 => 
            array (
                'id' => 362,
                'municipio' => 'SANTA CATARINA CUIXTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            290 => 
            array (
                'id' => 363,
                'municipio' => 'SANTA CATARINA IXTEPEJI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            291 => 
            array (
                'id' => 364,
                'municipio' => 'SANTA CATARINA JUQUILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            292 => 
            array (
                'id' => 365,
                'municipio' => 'SANTA CATARINA LACHATAO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            293 => 
            array (
                'id' => 366,
                'municipio' => 'SANTA CATARINA LOXICHA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            294 => 
            array (
                'id' => 367,
                'municipio' => 'SANTA CATARINA MECHOACAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            295 => 
            array (
                'id' => 368,
                'municipio' => 'SANTA CATARINA MINAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            296 => 
            array (
                'id' => 369,
                'municipio' => 'SANTA CATARINA QUIANE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            297 => 
            array (
                'id' => 370,
                'municipio' => 'SANTA CATARINA QUIOQUITANI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            298 => 
            array (
                'id' => 371,
                'municipio' => 'SANTA CATARINA TAYATA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            299 => 
            array (
                'id' => 372,
                'municipio' => 'SANTA CATARINA TICUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            300 => 
            array (
                'id' => 373,
                'municipio' => 'SANTA CATARINA YOSONOTU',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            301 => 
            array (
                'id' => 374,
                'municipio' => 'SANTA CATARINA ZAPOQUILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            302 => 
            array (
                'id' => 375,
                'municipio' => 'SANTA CRUZ ACATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            303 => 
            array (
                'id' => 376,
                'municipio' => 'SANTA CRUZ AMILPAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            304 => 
            array (
                'id' => 377,
                'municipio' => 'SANTA CRUZ DE BRAVO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            305 => 
            array (
                'id' => 378,
                'municipio' => 'SANTA CRUZ ITUNDUJIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            306 => 
            array (
                'id' => 379,
                'municipio' => 'SANTA CRUZ MIXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            307 => 
            array (
                'id' => 380,
                'municipio' => 'SANTA CRUZ NUNDACO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            308 => 
            array (
                'id' => 381,
                'municipio' => 'SANTA CRUZ PAPALUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            309 => 
            array (
                'id' => 382,
                'municipio' => 'SANTA CRUZ TACACHE DE MINA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            310 => 
            array (
                'id' => 383,
                'municipio' => 'SANTA CRUZ TACAHUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            311 => 
            array (
                'id' => 384,
                'municipio' => 'SANTA CRUZ TAYATA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            312 => 
            array (
                'id' => 385,
                'municipio' => 'SANTA CRUZ XITLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            313 => 
            array (
                'id' => 386,
                'municipio' => 'SANTA CRUZ XOXOCOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            314 => 
            array (
                'id' => 387,
                'municipio' => 'SANTA CRUZ ZENZONTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            315 => 
            array (
                'id' => 388,
                'municipio' => 'SANTA GERTRUDIS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            316 => 
            array (
                'id' => 389,
                'municipio' => 'SANTA INES DEL MONTE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            317 => 
            array (
                'id' => 390,
                'municipio' => 'SANTA INES YATZECHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            318 => 
            array (
                'id' => 391,
                'municipio' => 'SANTA INES DE ZARAGOZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            319 => 
            array (
                'id' => 392,
                'municipio' => 'SANTA LUCIA DEL CAMINO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            320 => 
            array (
                'id' => 393,
                'municipio' => 'SANTA LUCIA MIAHUATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            321 => 
            array (
                'id' => 394,
                'municipio' => 'SANTA LUCIA MONTEVERDE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            322 => 
            array (
                'id' => 395,
                'municipio' => 'SANTA LUCIA OCOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            323 => 
            array (
                'id' => 396,
                'municipio' => 'SANTA MAGDALENA JICOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            324 => 
            array (
                'id' => 397,
                'municipio' => 'SANTA MARIA ALOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            325 => 
            array (
                'id' => 398,
                'municipio' => 'SANTA MARIA APAZCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            326 => 
            array (
                'id' => 399,
                'municipio' => 'SANTA MARIA LA ASUNCION',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            327 => 
            array (
                'id' => 400,
                'municipio' => 'SANTA MARIA ATZOMPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            328 => 
            array (
                'id' => 401,
                'municipio' => 'SANTA MARIA CAMOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            329 => 
            array (
                'id' => 402,
                'municipio' => 'SANTA MARIA CHACHOAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            330 => 
            array (
                'id' => 403,
                'municipio' => 'VILLA DE CHILAPA DE DIAZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            331 => 
            array (
                'id' => 404,
                'municipio' => 'SANTA MARIA CHILCHOTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            332 => 
            array (
                'id' => 405,
                'municipio' => 'SANTA MARIA CHIMALAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            333 => 
            array (
                'id' => 406,
                'municipio' => 'SANTA MARIA COLOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            334 => 
            array (
                'id' => 407,
                'municipio' => 'SANTA MARIA CORTIJO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            335 => 
            array (
                'id' => 408,
                'municipio' => 'SANTA MARIA COYOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            336 => 
            array (
                'id' => 409,
                'municipio' => 'SANTA MARIA DEL ROSARIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            337 => 
            array (
                'id' => 410,
                'municipio' => 'SANTA MARIA DEL TULE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            338 => 
            array (
                'id' => 411,
                'municipio' => 'SANTA MARIA ECATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            339 => 
            array (
                'id' => 412,
                'municipio' => 'SANTA MARIA GUELACE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            340 => 
            array (
                'id' => 413,
                'municipio' => 'SANTA MARIA GUIENAGATI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            341 => 
            array (
                'id' => 414,
                'municipio' => 'SANTA MARIA HUATULCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            342 => 
            array (
                'id' => 415,
                'municipio' => 'SANTA MARIA HUAZOLOTITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            343 => 
            array (
                'id' => 416,
                'municipio' => 'SANTA MARIA IPALAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            344 => 
            array (
                'id' => 417,
                'municipio' => 'SANTA MARIA IXCATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            345 => 
            array (
                'id' => 418,
                'municipio' => 'SANTA MARIA JACATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            346 => 
            array (
                'id' => 419,
                'municipio' => 'SANTA MARIA JALAPA DEL MARQUES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            347 => 
            array (
                'id' => 420,
                'municipio' => 'SANTA MARIA JALTIANGUIS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            348 => 
            array (
                'id' => 421,
                'municipio' => 'SANTA MARIA LACHIXIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            349 => 
            array (
                'id' => 422,
                'municipio' => 'SANTA MARIA MIXTEQUILLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            350 => 
            array (
                'id' => 423,
                'municipio' => 'SANTA MARIA NATIVITAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            351 => 
            array (
                'id' => 424,
                'municipio' => 'SANTA MARIA NDUAYACO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            352 => 
            array (
                'id' => 425,
                'municipio' => 'SANTA MARIA OZOLOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            353 => 
            array (
                'id' => 426,
                'municipio' => 'SANTA MARIA PAPALO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            354 => 
            array (
                'id' => 427,
                'municipio' => 'SANTA MARIA PETAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            355 => 
            array (
                'id' => 428,
                'municipio' => 'SANTA MARIA PEÐOLES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            356 => 
            array (
                'id' => 429,
                'municipio' => 'SANTA MARIA QUIEGOLANI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            357 => 
            array (
                'id' => 430,
                'municipio' => 'SANTA MARIA SOLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            358 => 
            array (
                'id' => 431,
                'municipio' => 'SANTA MARIA TATALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            359 => 
            array (
                'id' => 432,
                'municipio' => 'SANTA MARIA TECOMAVACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            360 => 
            array (
                'id' => 433,
                'municipio' => 'SANTA MARIA TEMAXCALAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            361 => 
            array (
                'id' => 434,
                'municipio' => 'SANTA MARIA TEMAXCALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            362 => 
            array (
                'id' => 435,
                'municipio' => 'SANTA MARIA TEOPOXCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            363 => 
            array (
                'id' => 436,
                'municipio' => 'SANTA MARIA TEPANTLALI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            364 => 
            array (
                'id' => 437,
                'municipio' => 'SANTA MARIA TEXCATITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            365 => 
            array (
                'id' => 438,
                'municipio' => 'SANTA MARIA TLAHUITOLTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            366 => 
            array (
                'id' => 439,
                'municipio' => 'SANTA MARIA TLALIXTAC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            367 => 
            array (
                'id' => 440,
                'municipio' => 'SANTA MARIA TONAMECA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            368 => 
            array (
                'id' => 441,
                'municipio' => 'SANTA MARIA TOTOLAPILLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            369 => 
            array (
                'id' => 442,
                'municipio' => 'SANTA MARIA XADANI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            370 => 
            array (
                'id' => 443,
                'municipio' => 'SANTA MARIA YALINA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            371 => 
            array (
                'id' => 444,
                'municipio' => 'SANTA MARIA YAVESIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            372 => 
            array (
                'id' => 445,
                'municipio' => 'SANTA MARIA YOLOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            373 => 
            array (
                'id' => 446,
                'municipio' => 'SANTA MARIA YOSOYUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            374 => 
            array (
                'id' => 447,
                'municipio' => 'SANTA MARIA YUCUHITI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            375 => 
            array (
                'id' => 448,
                'municipio' => 'SANTA MARIA ZACATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            376 => 
            array (
                'id' => 449,
                'municipio' => 'SANTA MARIA ZANIZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            377 => 
            array (
                'id' => 450,
                'municipio' => 'SANTA MARIA ZOQUITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            378 => 
            array (
                'id' => 451,
                'municipio' => 'SANTIAGO AMOLTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            379 => 
            array (
                'id' => 452,
                'municipio' => 'SANTIAGO APOALA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            380 => 
            array (
                'id' => 453,
                'municipio' => 'SANTIAGO APOSTOL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            381 => 
            array (
                'id' => 454,
                'municipio' => 'SANTIAGO ASTATA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            382 => 
            array (
                'id' => 455,
                'municipio' => 'SANTIAGO ATITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            383 => 
            array (
                'id' => 456,
                'municipio' => 'SANTIAGO AYUQUILILLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            384 => 
            array (
                'id' => 457,
                'municipio' => 'SANTIAGO CACALOXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            385 => 
            array (
                'id' => 458,
                'municipio' => 'SANTIAGO CAMOTLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            386 => 
            array (
                'id' => 459,
                'municipio' => 'SANTIAGO CHAZUMBA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            387 => 
            array (
                'id' => 460,
                'municipio' => 'SANTIAGO CHOAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            388 => 
            array (
                'id' => 461,
                'municipio' => 'SANTIAGO COMALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            389 => 
            array (
                'id' => 462,
                'municipio' => 'SANTIAGO DEL RIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            390 => 
            array (
                'id' => 463,
                'municipio' => 'SANTIAGO HUAJOLOTITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            391 => 
            array (
                'id' => 464,
                'municipio' => 'SANTIAGO HUAUCLILLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            392 => 
            array (
                'id' => 465,
                'municipio' => 'SANTIAGO IHUITLAN PLUMAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            393 => 
            array (
                'id' => 466,
                'municipio' => 'SANTIAGO IXCUINTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            394 => 
            array (
                'id' => 467,
                'municipio' => 'SANTIAGO IXTAYUTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            395 => 
            array (
                'id' => 468,
                'municipio' => 'SANTIAGO JAMILTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            396 => 
            array (
                'id' => 469,
                'municipio' => 'SANTIAGO JOCOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            397 => 
            array (
                'id' => 470,
                'municipio' => 'SANTIAGO JUXTLAHUACA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            398 => 
            array (
                'id' => 471,
                'municipio' => 'SANTIAGO LACHIGUIRI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            399 => 
            array (
                'id' => 472,
                'municipio' => 'SANTIAGO LALOPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            400 => 
            array (
                'id' => 473,
                'municipio' => 'SANTIAGO LAOLLAGA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            401 => 
            array (
                'id' => 474,
                'municipio' => 'SANTIAGO LAXOPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            402 => 
            array (
                'id' => 475,
                'municipio' => 'SANTIAGO LLANO GRANDE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            403 => 
            array (
                'id' => 476,
                'municipio' => 'SANTIAGO MATATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            404 => 
            array (
                'id' => 477,
                'municipio' => 'SANTIAGO MILTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            405 => 
            array (
                'id' => 478,
                'municipio' => 'SANTIAGO MINAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            406 => 
            array (
                'id' => 479,
                'municipio' => 'SANTIAGO NACALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            407 => 
            array (
                'id' => 480,
                'municipio' => 'SANTIAGO NEJAPILLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            408 => 
            array (
                'id' => 481,
                'municipio' => 'SANTIAGO NILTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            409 => 
            array (
                'id' => 482,
                'municipio' => 'SANTIAGO NUNDICHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            410 => 
            array (
                'id' => 483,
                'municipio' => 'SANTIAGO NUYOO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            411 => 
            array (
                'id' => 484,
                'municipio' => 'SANTIAGO PINOTEPA NACIONAL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            412 => 
            array (
                'id' => 485,
                'municipio' => 'SANTIAGO SUCHILQUITONGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            413 => 
            array (
                'id' => 486,
                'municipio' => 'SANTIAGO TAMAZOLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            414 => 
            array (
                'id' => 487,
                'municipio' => 'SANTIAGO TAPEXTLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            415 => 
            array (
                'id' => 488,
                'municipio' => 'SANTIAGO TENANGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            416 => 
            array (
                'id' => 489,
                'municipio' => 'SANTIAGO TEPETLAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            417 => 
            array (
                'id' => 490,
                'municipio' => 'SANTIAGO TETEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            418 => 
            array (
                'id' => 491,
                'municipio' => 'SANTIAGO TEXCALCINGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            419 => 
            array (
                'id' => 492,
                'municipio' => 'SANTIAGO TEXTITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            420 => 
            array (
                'id' => 493,
                'municipio' => 'SANTIAGO TILANTONGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            421 => 
            array (
                'id' => 494,
                'municipio' => 'SANTIAGO TILLO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            422 => 
            array (
                'id' => 495,
                'municipio' => 'SANTIAGO TLAZOYALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            423 => 
            array (
                'id' => 496,
                'municipio' => 'SANTIAGO XANICA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            424 => 
            array (
                'id' => 497,
                'municipio' => 'SANTIAGO XIACUI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            425 => 
            array (
                'id' => 498,
                'municipio' => 'SANTIAGO YAITEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            426 => 
            array (
                'id' => 499,
                'municipio' => 'SANTIAGO YAVEO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            427 => 
            array (
                'id' => 500,
                'municipio' => 'SANTIAGO YOLOMECATL',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            428 => 
            array (
                'id' => 501,
                'municipio' => 'SANTIAGO YOSONDUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            429 => 
            array (
                'id' => 502,
                'municipio' => 'SANTIAGO YUCUYACHI',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            430 => 
            array (
                'id' => 503,
                'municipio' => 'SANTIAGO ZACATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            431 => 
            array (
                'id' => 504,
                'municipio' => 'SANTIAGO ZOOCHILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            432 => 
            array (
                'id' => 505,
                'municipio' => 'SANTO DOMINGO ALBARRADAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            433 => 
            array (
                'id' => 506,
                'municipio' => 'SANTO DOMINGO ARMENTA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            434 => 
            array (
                'id' => 507,
                'municipio' => 'SANTO DOMINGO CHIHUITAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            435 => 
            array (
                'id' => 508,
                'municipio' => 'SANTO DOMINGO DE MORELOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            436 => 
            array (
                'id' => 509,
                'municipio' => 'SANTO DOMINGO INGENIO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            437 => 
            array (
                'id' => 510,
                'municipio' => 'SANTO DOMINGO IXCATLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            438 => 
            array (
                'id' => 511,
                'municipio' => 'SANTO DOMINGO NUXAA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            439 => 
            array (
                'id' => 512,
                'municipio' => 'SANTO DOMINGO OZOLOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            440 => 
            array (
                'id' => 513,
                'municipio' => 'SANTO DOMINGO PETAPA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            441 => 
            array (
                'id' => 514,
                'municipio' => 'SANTO DOMINGO ROAYAGA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            442 => 
            array (
                'id' => 515,
                'municipio' => 'SANTO DOMINGO TEHUANTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            443 => 
            array (
                'id' => 516,
                'municipio' => 'SANTO DOMINGO TEOJOMULCO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            444 => 
            array (
                'id' => 517,
                'municipio' => 'SANTO DOMINGO TEPUXTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            445 => 
            array (
                'id' => 518,
                'municipio' => 'SANTO DOMINGO TLATAYAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            446 => 
            array (
                'id' => 519,
                'municipio' => 'SANTO DOMINGO TOMALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            447 => 
            array (
                'id' => 520,
                'municipio' => 'SANTO DOMINGO TONALA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            448 => 
            array (
                'id' => 521,
                'municipio' => 'SANTO DOMINGO TONALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            449 => 
            array (
                'id' => 522,
                'municipio' => 'SANTO DOMINGO XAGACIA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            450 => 
            array (
                'id' => 523,
                'municipio' => 'SANTO DOMINGO YANHUITLAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            451 => 
            array (
                'id' => 524,
                'municipio' => 'SANTO DOMINGO YODOHINO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            452 => 
            array (
                'id' => 525,
                'municipio' => 'SANTO DOMINGO ZANATEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            453 => 
            array (
                'id' => 526,
                'municipio' => 'SANTO TOMAS JALIEZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            454 => 
            array (
                'id' => 527,
                'municipio' => 'SANTO TOMAS MAZALTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            455 => 
            array (
                'id' => 528,
                'municipio' => 'SANTO TOMAS OCOTEPEC',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            456 => 
            array (
                'id' => 529,
                'municipio' => 'SANTO TOMAS TAMAZULAPAN',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            457 => 
            array (
                'id' => 530,
                'municipio' => 'SANTOS REYES NOPALA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            458 => 
            array (
                'id' => 531,
                'municipio' => 'SANTOS REYES PAPALO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            459 => 
            array (
                'id' => 532,
                'municipio' => 'SANTOS REYES TEPEJILLO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            460 => 
            array (
                'id' => 533,
                'municipio' => 'SANTOS REYES YUCUNA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            461 => 
            array (
                'id' => 534,
                'municipio' => 'SILACAYOAPAM',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            462 => 
            array (
                'id' => 535,
                'municipio' => 'SITIO DE XITLAPEHUA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            463 => 
            array (
                'id' => 536,
                'municipio' => 'VILLA SOLA DE VEGA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            464 => 
            array (
                'id' => 537,
                'municipio' => 'SOLEDAD ETLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            465 => 
            array (
                'id' => 538,
                'municipio' => 'TANICHE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            466 => 
            array (
                'id' => 539,
                'municipio' => 'VILLA DE TAMAZULAPAM DEL PROGRESO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            467 => 
            array (
                'id' => 540,
                'municipio' => 'TAMAZULAPAM DEL ESPIRITU SANTO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            468 => 
            array (
                'id' => 541,
                'municipio' => 'TANETZE DE ZARAGOZA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            469 => 
            array (
                'id' => 542,
                'municipio' => 'TATALTEPEC DE VALDES',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            470 => 
            array (
                'id' => 543,
                'municipio' => 'VILLA TEJUPAM DE LA UNION',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            471 => 
            array (
                'id' => 544,
                'municipio' => 'TEOCOCUILCO DE MARCOS PEREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            472 => 
            array (
                'id' => 545,
                'municipio' => 'TEOTITLAN DE FLORES MAGON',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            473 => 
            array (
                'id' => 546,
                'municipio' => 'TEOTITLAN DEL VALLE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            474 => 
            array (
                'id' => 547,
                'municipio' => 'TEOTONGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            475 => 
            array (
                'id' => 548,
                'municipio' => 'TEPELMEME VILLA DE MORELOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            476 => 
            array (
                'id' => 549,
                'municipio' => 'H VILLA TEZOATLAN SEGURA Y LUNA CUNA IND OAX',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            477 => 
            array (
                'id' => 550,
                'municipio' => 'TLACOLULA DE MATAMOROS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            478 => 
            array (
                'id' => 551,
                'municipio' => 'TLACOTEPEC PLUMAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            479 => 
            array (
                'id' => 552,
                'municipio' => 'TLALIXTAC DE CABRERA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            480 => 
            array (
                'id' => 553,
                'municipio' => 'HEROICA CIUDAD DE TLAXIACO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            481 => 
            array (
                'id' => 554,
                'municipio' => 'TOTONTEPEC VILLA DE MORELOS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            482 => 
            array (
                'id' => 555,
                'municipio' => 'TRINIDAD ZAACHILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            483 => 
            array (
                'id' => 556,
                'municipio' => 'LA TRINIDAD VISTA HERMOSA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            484 => 
            array (
                'id' => 557,
                'municipio' => 'UNION HIDALGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            485 => 
            array (
                'id' => 558,
                'municipio' => 'VALERIO TRUJANO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            486 => 
            array (
                'id' => 559,
                'municipio' => 'CAPULALPAM DE MENDEZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            487 => 
            array (
                'id' => 560,
                'municipio' => 'VILLA DE ETLA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            488 => 
            array (
                'id' => 561,
                'municipio' => 'VILLA DIAZ ORDAZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            489 => 
            array (
                'id' => 562,
                'municipio' => 'VILLA HIDALGO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            490 => 
            array (
                'id' => 563,
                'municipio' => 'YAXE',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            491 => 
            array (
                'id' => 564,
                'municipio' => 'YOGANA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            492 => 
            array (
                'id' => 565,
                'municipio' => 'YUTANDUCHI DE GUERRERO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            493 => 
            array (
                'id' => 566,
                'municipio' => 'VILLA DE ZAACHILA',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            494 => 
            array (
                'id' => 567,
                'municipio' => 'SAN MATEO YUCUTINDOO',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            495 => 
            array (
                'id' => 568,
                'municipio' => 'ZAPOTITLAN LAGUNAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            496 => 
            array (
                'id' => 569,
                'municipio' => 'ZAPOTITLAN PALMAS',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            497 => 
            array (
                'id' => 570,
                'municipio' => 'ZIMATLAN DE ALVAREZ',
                'id_estado' => 20,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            498 => 
            array (
                'id' => 1,
                'municipio' => 'ACAJETE',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            499 => 
            array (
                'id' => 2,
                'municipio' => 'ACATENO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        \DB::table('cat_municipios')->insert(array (
            0 => 
            array (
                'id' => 3,
                'municipio' => 'ACATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 4,
                'municipio' => 'ACATZINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 5,
                'municipio' => 'ACTEOPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 6,
                'municipio' => 'AHUACATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 7,
                'municipio' => 'AHUATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 8,
                'municipio' => 'AHUAZOTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 9,
                'municipio' => 'AHUEHUETITLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 10,
                'municipio' => 'AJALPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 11,
                'municipio' => 'ALBINO ZERTUCHE',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 12,
                'municipio' => 'ALJOJUCA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 13,
                'municipio' => 'ALTEPEXI',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 14,
                'municipio' => 'AMIXTLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 15,
                'municipio' => 'AMOZOC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 16,
                'municipio' => 'AQUIXTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 17,
                'municipio' => 'ATEMPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 18,
                'municipio' => 'ATEXCAL',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 19,
                'municipio' => 'ATLIXCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 20,
                'municipio' => 'ATOYATEMPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 21,
                'municipio' => 'ATZALA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 22,
                'municipio' => 'ATZITZIHUACAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 23,
                'municipio' => 'ATZITZINTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 24,
                'municipio' => 'AXUTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 25,
                'municipio' => 'AYOTOXCO DE GUERRERO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 26,
                'municipio' => 'CALPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 27,
                'municipio' => 'CALTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 28,
                'municipio' => 'CAMOCUAUTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 29,
                'municipio' => 'CAÐADA MORELOS',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 30,
                'municipio' => 'CAXHUACAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 31,
                'municipio' => 'COATEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 32,
                'municipio' => 'COATZINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 33,
                'municipio' => 'COHETZALA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 34,
                'municipio' => 'COHUECAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 35,
                'municipio' => 'CORONANGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 36,
                'municipio' => 'COXCATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 37,
                'municipio' => 'COYOMEAPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 38,
                'municipio' => 'COYOTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 39,
                'municipio' => 'CUAPIAXTLA DE MADERO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 40,
                'municipio' => 'CUAUTEMPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 41,
                'municipio' => 'CUAUTINCHAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 42,
                'municipio' => 'CUAUTLANCINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 43,
                'municipio' => 'CUAYUCA DE ANDRADE',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 44,
                'municipio' => 'CUETZALAN DEL PROGRESO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 45,
                'municipio' => 'CUYOACO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 46,
                'municipio' => 'CHALCHICOMULA DE SESMA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 47,
                'municipio' => 'CHAPULCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 48,
                'municipio' => 'CHIAUTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 49,
                'municipio' => 'CHIAUTZINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 50,
                'municipio' => 'CHICONCUAUTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 51,
                'municipio' => 'CHICHIQUILA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 52,
                'municipio' => 'CHIETLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 53,
                'municipio' => 'CHIGMECATITLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 54,
                'municipio' => 'CHIGNAHUAPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 55,
                'municipio' => 'CHIGNAUTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 56,
                'municipio' => 'CHILA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 57,
                'municipio' => 'CHILA DE LA SAL',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 58,
                'municipio' => 'HONEY',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 59,
                'municipio' => 'CHILCHOTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 60,
                'municipio' => 'CHINANTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 61,
                'municipio' => 'DOMINGO ARENAS',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 62,
                'municipio' => 'ELOXOCHITLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 63,
                'municipio' => 'EPATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 64,
                'municipio' => 'ESPERANZA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 65,
                'municipio' => 'FRANCISCO Z. MENA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 66,
                'municipio' => 'GENERAL FELIPE ANGELES',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 67,
                'municipio' => 'GUADALUPE',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 68,
                'municipio' => 'GUADALUPE VICTORIA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 69,
                'municipio' => 'HERMENEGILDO GALEANA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 70,
                'municipio' => 'HUAQUECHULA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 71,
                'municipio' => 'HUATLATLAUCA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 72,
                'municipio' => 'HUAUCHINANGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 73,
                'municipio' => 'HUEHUETLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 74,
                'municipio' => 'HUEHUETLAN EL CHICO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 75,
                'municipio' => 'HUEHUETLAN EL GRANDE',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 76,
                'municipio' => 'HUEJOTZINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 77,
                'municipio' => 'HUEYAPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 78,
                'municipio' => 'HUEYTAMALCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 79,
                'municipio' => 'HUEYTLALPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 80,
                'municipio' => 'HUITZILAN DE SERDAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 81,
                'municipio' => 'HUITZILTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 82,
                'municipio' => 'ATLEQUIZAYAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 83,
                'municipio' => 'IXCAMILPA DE GUERRERO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 84,
                'municipio' => 'IXCAQUIXTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 85,
                'municipio' => 'IXTACAMAXTITLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 86,
                'municipio' => 'IXTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 87,
                'municipio' => 'IZUCAR DE MATAMOROS',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 88,
                'municipio' => 'JALPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 89,
                'municipio' => 'JOLALPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 90,
                'municipio' => 'JONOTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 91,
                'municipio' => 'JOPALA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 92,
                'municipio' => 'JUAN C. BONILLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 93,
                'municipio' => 'JUAN GALINDO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 94,
                'municipio' => 'JUAN N. MENDEZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 95,
                'municipio' => 'LAFRAGUA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 96,
                'municipio' => 'LIBRES',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 => 
            array (
                'id' => 97,
                'municipio' => 'LA MAGDALENA TLATLAUQUITEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 => 
            array (
                'id' => 98,
                'municipio' => 'MAZAPILTEPEC DE JUAREZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 => 
            array (
                'id' => 99,
                'municipio' => 'MIXTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 => 
            array (
                'id' => 100,
                'municipio' => 'MOLCAXAC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 => 
            array (
                'id' => 101,
                'municipio' => 'NAUPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 => 
            array (
                'id' => 102,
                'municipio' => 'NAUZONTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 => 
            array (
                'id' => 103,
                'municipio' => 'NEALTICAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 => 
            array (
                'id' => 104,
                'municipio' => 'NICOLAS BRAVO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 => 
            array (
                'id' => 105,
                'municipio' => 'NOPALUCAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 => 
            array (
                'id' => 106,
                'municipio' => 'OCOTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 => 
            array (
                'id' => 107,
                'municipio' => 'OCOYUCAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 => 
            array (
                'id' => 108,
                'municipio' => 'OLINTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 => 
            array (
                'id' => 109,
                'municipio' => 'ORIENTAL',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 => 
            array (
                'id' => 110,
                'municipio' => 'PAHUATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 => 
            array (
                'id' => 111,
                'municipio' => 'PALMAR DE BRAVO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 => 
            array (
                'id' => 112,
                'municipio' => 'PANTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 => 
            array (
                'id' => 113,
                'municipio' => 'PETLALCINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 => 
            array (
                'id' => 114,
                'municipio' => 'PIAXTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 => 
            array (
                'id' => 115,
                'municipio' => 'PUEBLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 => 
            array (
                'id' => 116,
                'municipio' => 'QUECHOLAC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            114 => 
            array (
                'id' => 117,
                'municipio' => 'QUIMIXTLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            115 => 
            array (
                'id' => 118,
                'municipio' => 'RAFAEL LARA GRAJALES',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            116 => 
            array (
                'id' => 119,
                'municipio' => 'LOS REYES DE JUAREZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            117 => 
            array (
                'id' => 120,
                'municipio' => 'SAN ANDRES CHOLULA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            118 => 
            array (
                'id' => 121,
                'municipio' => 'SAN ANTONIO CAÐADA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            119 => 
            array (
                'id' => 122,
                'municipio' => 'SAN DIEGO LA MESA TOCHIMILTZINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            120 => 
            array (
                'id' => 123,
                'municipio' => 'SAN FELIPE TEOTLALCINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            121 => 
            array (
                'id' => 124,
                'municipio' => 'SAN FELIPE TEPATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            122 => 
            array (
                'id' => 125,
                'municipio' => 'SAN GABRIEL CHILAC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            123 => 
            array (
                'id' => 126,
                'municipio' => 'SAN GREGORIO ATZOMPA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            124 => 
            array (
                'id' => 127,
                'municipio' => 'SAN JERONIMO TECUANIPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            125 => 
            array (
                'id' => 128,
                'municipio' => 'SAN JERONIMO XAYACATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            126 => 
            array (
                'id' => 129,
                'municipio' => 'SAN JOSE CHIAPA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            127 => 
            array (
                'id' => 130,
                'municipio' => 'SAN JOSE MIAHUATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            128 => 
            array (
                'id' => 131,
                'municipio' => 'SAN JUAN ATENCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            129 => 
            array (
                'id' => 132,
                'municipio' => 'SAN JUAN ATZOMPA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            130 => 
            array (
                'id' => 133,
                'municipio' => 'SAN MARTIN TEXMELUCAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            131 => 
            array (
                'id' => 134,
                'municipio' => 'SAN MARTIN TOTOLTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            132 => 
            array (
                'id' => 135,
                'municipio' => 'SAN MATIAS TLALANCALECA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            133 => 
            array (
                'id' => 136,
                'municipio' => 'SAN MIGUEL IXITLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            134 => 
            array (
                'id' => 137,
                'municipio' => 'SAN MIGUEL XOXTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            135 => 
            array (
                'id' => 138,
                'municipio' => 'SAN NICOLAS BUENOS AIRES',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            136 => 
            array (
                'id' => 139,
                'municipio' => 'SAN NICOLAS DE LOS RANCHOS',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            137 => 
            array (
                'id' => 140,
                'municipio' => 'SAN PABLO ANICANO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            138 => 
            array (
                'id' => 141,
                'municipio' => 'SAN PEDRO CHOLULA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            139 => 
            array (
                'id' => 142,
                'municipio' => 'SAN PEDRO YELOIXTLAHUACA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            140 => 
            array (
                'id' => 143,
                'municipio' => 'SAN SALVADOR EL SECO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            141 => 
            array (
                'id' => 144,
                'municipio' => 'SAN SALVADOR EL VERDE',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            142 => 
            array (
                'id' => 145,
                'municipio' => 'SAN SALVADOR HUIXCOLOTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            143 => 
            array (
                'id' => 146,
                'municipio' => 'SANTA CATARINA TLALTEMPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            144 => 
            array (
                'id' => 147,
                'municipio' => 'SANTA INES AHUATEMPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            145 => 
            array (
                'id' => 148,
                'municipio' => 'SANTA ISABEL CHOLULA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            146 => 
            array (
                'id' => 149,
                'municipio' => 'SANTIAGO MIAHUATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            147 => 
            array (
                'id' => 150,
                'municipio' => 'SANTO TOMAS HUEYOTLIPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            148 => 
            array (
                'id' => 151,
                'municipio' => 'SOLTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            149 => 
            array (
                'id' => 152,
                'municipio' => 'TECALI DE HERRERA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            150 => 
            array (
                'id' => 153,
                'municipio' => 'TECAMACHALCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            151 => 
            array (
                'id' => 154,
                'municipio' => 'TECOMATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            152 => 
            array (
                'id' => 155,
                'municipio' => 'TEHUACAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            153 => 
            array (
                'id' => 156,
                'municipio' => 'TEHUITZINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            154 => 
            array (
                'id' => 157,
                'municipio' => 'TENAMPULCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            155 => 
            array (
                'id' => 158,
                'municipio' => 'TEOPANTLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            156 => 
            array (
                'id' => 159,
                'municipio' => 'TEOTLALCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            157 => 
            array (
                'id' => 160,
                'municipio' => 'TEPANCO DE LOPEZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            158 => 
            array (
                'id' => 161,
                'municipio' => 'TEPANGO DE RODRIGUEZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            159 => 
            array (
                'id' => 162,
                'municipio' => 'TEPATLAXCO DE HIDALGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            160 => 
            array (
                'id' => 163,
                'municipio' => 'TEPEACA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            161 => 
            array (
                'id' => 164,
                'municipio' => 'TEPEMAXALCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            162 => 
            array (
                'id' => 165,
                'municipio' => 'TEPEOJUMA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            163 => 
            array (
                'id' => 166,
                'municipio' => 'TEPETZINTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            164 => 
            array (
                'id' => 167,
                'municipio' => 'TEPEXCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            165 => 
            array (
                'id' => 168,
                'municipio' => 'TEPEXI DE RODRIGUEZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            166 => 
            array (
                'id' => 169,
                'municipio' => 'TEPEYAHUALCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            167 => 
            array (
                'id' => 170,
                'municipio' => 'TEPEYAHUALCO DE CUAUHTEMOC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            168 => 
            array (
                'id' => 171,
                'municipio' => 'TETELA DE OCAMPO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            169 => 
            array (
                'id' => 172,
                'municipio' => 'TETELES DE AVILA CASTILLO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            170 => 
            array (
                'id' => 173,
                'municipio' => 'TEZIUTLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            171 => 
            array (
                'id' => 174,
                'municipio' => 'TIANGUISMANALCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            172 => 
            array (
                'id' => 175,
                'municipio' => 'TILAPA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            173 => 
            array (
                'id' => 176,
                'municipio' => 'TLACOTEPEC DE BENITO JUAREZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            174 => 
            array (
                'id' => 177,
                'municipio' => 'SAN SEBASTIAN TLACOTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            175 => 
            array (
                'id' => 178,
                'municipio' => 'TLACUILOTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            176 => 
            array (
                'id' => 179,
                'municipio' => 'TLACHICHUCA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            177 => 
            array (
                'id' => 180,
                'municipio' => 'TLAHUAPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            178 => 
            array (
                'id' => 181,
                'municipio' => 'TLALTENANGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            179 => 
            array (
                'id' => 182,
                'municipio' => 'TLANEPANTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            180 => 
            array (
                'id' => 183,
                'municipio' => 'TLAOLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            181 => 
            array (
                'id' => 184,
                'municipio' => 'TLAPACOYA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            182 => 
            array (
                'id' => 185,
                'municipio' => 'TLAPANALA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            183 => 
            array (
                'id' => 186,
                'municipio' => 'TLATLAUQUITEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            184 => 
            array (
                'id' => 187,
                'municipio' => 'TLAXCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            185 => 
            array (
                'id' => 188,
                'municipio' => 'TOCHIMILCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            186 => 
            array (
                'id' => 189,
                'municipio' => 'TOCHTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            187 => 
            array (
                'id' => 190,
                'municipio' => 'TOTOLTEPEC DE GUERRERO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            188 => 
            array (
                'id' => 191,
                'municipio' => 'TULCINGO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            189 => 
            array (
                'id' => 192,
                'municipio' => 'TUZAMAPAN DE GALEANA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            190 => 
            array (
                'id' => 193,
                'municipio' => 'TZICATLACOYAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            191 => 
            array (
                'id' => 194,
                'municipio' => 'VENUSTIANO CARRANZA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            192 => 
            array (
                'id' => 195,
                'municipio' => 'VICENTE GUERRERO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            193 => 
            array (
                'id' => 196,
                'municipio' => 'XAYACATLAN DE BRAVO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            194 => 
            array (
                'id' => 197,
                'municipio' => 'XICOTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            195 => 
            array (
                'id' => 198,
                'municipio' => 'XICOTLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            196 => 
            array (
                'id' => 199,
                'municipio' => 'XIUTETELCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            197 => 
            array (
                'id' => 200,
                'municipio' => 'XOCHIAPULCO',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            198 => 
            array (
                'id' => 201,
                'municipio' => 'XOCHILTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            199 => 
            array (
                'id' => 202,
                'municipio' => 'XOCHITLAN DE VICENTE SUAREZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            200 => 
            array (
                'id' => 203,
                'municipio' => 'XOCHITLAN TODOS SANTOS',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            201 => 
            array (
                'id' => 204,
                'municipio' => 'YAONAHUAC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            202 => 
            array (
                'id' => 205,
                'municipio' => 'YEHUALTEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            203 => 
            array (
                'id' => 206,
                'municipio' => 'ZACAPALA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            204 => 
            array (
                'id' => 207,
                'municipio' => 'ZACAPOAXTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            205 => 
            array (
                'id' => 208,
                'municipio' => 'ZACATLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            206 => 
            array (
                'id' => 209,
                'municipio' => 'ZAPOTITLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            207 => 
            array (
                'id' => 210,
                'municipio' => 'ZAPOTITLAN DE MENDEZ',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            208 => 
            array (
                'id' => 211,
                'municipio' => 'ZARAGOZA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            209 => 
            array (
                'id' => 212,
                'municipio' => 'ZAUTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            210 => 
            array (
                'id' => 213,
                'municipio' => 'ZIHUATEUTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            211 => 
            array (
                'id' => 214,
                'municipio' => 'ZINACATEPEC',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            212 => 
            array (
                'id' => 215,
                'municipio' => 'ZONGOZOTLA',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            213 => 
            array (
                'id' => 216,
                'municipio' => 'ZOQUIAPAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            214 => 
            array (
                'id' => 217,
                'municipio' => 'ZOQUITLAN',
                'id_estado' => 21,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            215 => 
            array (
                'id' => 1,
                'municipio' => 'AMEALCO DE BONFIL',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            216 => 
            array (
                'id' => 2,
                'municipio' => 'ARROYO SECO',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            217 => 
            array (
                'id' => 3,
                'municipio' => 'CADEREYTA DE MONTES',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            218 => 
            array (
                'id' => 4,
                'municipio' => 'COLON',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            219 => 
            array (
                'id' => 5,
                'municipio' => 'CORREGIDORA',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            220 => 
            array (
                'id' => 6,
                'municipio' => 'EZEQUIEL MONTES',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            221 => 
            array (
                'id' => 7,
                'municipio' => 'HUIMILPAN',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            222 => 
            array (
                'id' => 8,
                'municipio' => 'JALPAN DE SERRA',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            223 => 
            array (
                'id' => 9,
                'municipio' => 'LANDA DE MATAMOROS',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            224 => 
            array (
                'id' => 10,
                'municipio' => 'EL MARQUES',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            225 => 
            array (
                'id' => 11,
                'municipio' => 'PEDRO ESCOBEDO',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            226 => 
            array (
                'id' => 12,
                'municipio' => 'PEÐAMILLER',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            227 => 
            array (
                'id' => 13,
                'municipio' => 'PINAL DE AMOLES',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            228 => 
            array (
                'id' => 14,
                'municipio' => 'QUERETARO',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            229 => 
            array (
                'id' => 15,
                'municipio' => 'SAN JOAQUIN',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            230 => 
            array (
                'id' => 16,
                'municipio' => 'SAN JUAN DEL RIO',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            231 => 
            array (
                'id' => 17,
                'municipio' => 'TEQUISQUIAPAN',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            232 => 
            array (
                'id' => 18,
                'municipio' => 'TOLIMAN',
                'id_estado' => 22,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            233 => 
            array (
                'id' => 1,
                'municipio' => 'BENITO JUAREZ',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            234 => 
            array (
                'id' => 2,
                'municipio' => 'COZUMEL',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            235 => 
            array (
                'id' => 3,
                'municipio' => 'FELIPE CARRILLO PUERTO',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            236 => 
            array (
                'id' => 4,
                'municipio' => 'ISLA MUJERES',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            237 => 
            array (
                'id' => 5,
                'municipio' => 'JOSE MARIA MORELOS',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            238 => 
            array (
                'id' => 6,
                'municipio' => 'LAZARO CARDENAS',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            239 => 
            array (
                'id' => 7,
                'municipio' => 'OTHON P. BLANCO',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            240 => 
            array (
                'id' => 8,
                'municipio' => 'SOLIDARIDAD',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            241 => 
            array (
                'id' => 9,
                'municipio' => 'TULUM',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            242 => 
            array (
                'id' => 10,
                'municipio' => 'BACALAR',
                'id_estado' => 23,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            243 => 
            array (
                'id' => 1,
                'municipio' => 'AHUALULCO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            244 => 
            array (
                'id' => 2,
                'municipio' => 'ALAQUINES',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            245 => 
            array (
                'id' => 3,
                'municipio' => 'AQUISMON',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            246 => 
            array (
                'id' => 4,
                'municipio' => 'ARMADILLO DE LOS INFANTE',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            247 => 
            array (
                'id' => 5,
                'municipio' => 'CARDENAS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            248 => 
            array (
                'id' => 6,
                'municipio' => 'CATORCE',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            249 => 
            array (
                'id' => 7,
                'municipio' => 'CEDRAL',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            250 => 
            array (
                'id' => 8,
                'municipio' => 'CERRITOS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            251 => 
            array (
                'id' => 9,
                'municipio' => 'CERRO DE SAN PEDRO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            252 => 
            array (
                'id' => 10,
                'municipio' => 'CIUDAD DEL MAIZ',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            253 => 
            array (
                'id' => 11,
                'municipio' => 'CIUDAD FERNANDEZ',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            254 => 
            array (
                'id' => 12,
                'municipio' => 'TANCANHUITZ',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            255 => 
            array (
                'id' => 13,
                'municipio' => 'CIUDAD VALLES',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            256 => 
            array (
                'id' => 14,
                'municipio' => 'COXCATLAN',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            257 => 
            array (
                'id' => 15,
                'municipio' => 'CHARCAS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            258 => 
            array (
                'id' => 16,
                'municipio' => 'EBANO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            259 => 
            array (
                'id' => 17,
                'municipio' => 'GUADALCAZAR',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            260 => 
            array (
                'id' => 18,
                'municipio' => 'HUEHUETLAN',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            261 => 
            array (
                'id' => 19,
                'municipio' => 'LAGUNILLAS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            262 => 
            array (
                'id' => 20,
                'municipio' => 'MATEHUALA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            263 => 
            array (
                'id' => 21,
                'municipio' => 'MEXQUITIC DE CARMONA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            264 => 
            array (
                'id' => 22,
                'municipio' => 'MOCTEZUMA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            265 => 
            array (
                'id' => 23,
                'municipio' => 'RAYON',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            266 => 
            array (
                'id' => 24,
                'municipio' => 'RIOVERDE',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            267 => 
            array (
                'id' => 25,
                'municipio' => 'SALINAS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            268 => 
            array (
                'id' => 26,
                'municipio' => 'SAN ANTONIO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            269 => 
            array (
                'id' => 27,
                'municipio' => 'SAN CIRO DE ACOSTA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            270 => 
            array (
                'id' => 28,
                'municipio' => 'SAN LUIS POTOSI',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            271 => 
            array (
                'id' => 29,
                'municipio' => 'SAN MARTIN CHALCHICUAUTLA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            272 => 
            array (
                'id' => 30,
                'municipio' => 'SAN NICOLAS TOLENTINO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            273 => 
            array (
                'id' => 31,
                'municipio' => 'SAN VICENTE TANCUAYALAB',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            274 => 
            array (
                'id' => 32,
                'municipio' => 'SANTA CATARINA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            275 => 
            array (
                'id' => 33,
                'municipio' => 'SANTA MARIA DEL RIO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            276 => 
            array (
                'id' => 34,
                'municipio' => 'SANTO DOMINGO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            277 => 
            array (
                'id' => 35,
                'municipio' => 'SOLEDAD DE GRACIANO SANCHEZ',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            278 => 
            array (
                'id' => 36,
                'municipio' => 'TAMASOPO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            279 => 
            array (
                'id' => 37,
                'municipio' => 'TAMAZUNCHALE',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            280 => 
            array (
                'id' => 38,
                'municipio' => 'TAMPACAN',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            281 => 
            array (
                'id' => 39,
                'municipio' => 'TAMPAMOLON CORONA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            282 => 
            array (
                'id' => 40,
                'municipio' => 'TAMUIN',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            283 => 
            array (
                'id' => 41,
                'municipio' => 'TANLAJAS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            284 => 
            array (
                'id' => 42,
                'municipio' => 'TANQUIAN DE ESCOBEDO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            285 => 
            array (
                'id' => 43,
                'municipio' => 'TIERRA NUEVA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            286 => 
            array (
                'id' => 44,
                'municipio' => 'VANEGAS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            287 => 
            array (
                'id' => 45,
                'municipio' => 'VENADO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            288 => 
            array (
                'id' => 46,
                'municipio' => 'VILLA DE ARISTA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            289 => 
            array (
                'id' => 47,
                'municipio' => 'VILLA DE ARRIAGA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            290 => 
            array (
                'id' => 48,
                'municipio' => 'VILLA DE GUADALUPE',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            291 => 
            array (
                'id' => 49,
                'municipio' => 'VILLA DE LA PAZ',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            292 => 
            array (
                'id' => 50,
                'municipio' => 'VILLA DE RAMOS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            293 => 
            array (
                'id' => 51,
                'municipio' => 'VILLA DE REYES',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            294 => 
            array (
                'id' => 52,
                'municipio' => 'VILLA HIDALGO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            295 => 
            array (
                'id' => 53,
                'municipio' => 'VILLA JUAREZ',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            296 => 
            array (
                'id' => 54,
                'municipio' => 'AXTLA DE TERRAZAS',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            297 => 
            array (
                'id' => 55,
                'municipio' => 'XILITLA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            298 => 
            array (
                'id' => 56,
                'municipio' => 'ZARAGOZA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            299 => 
            array (
                'id' => 57,
                'municipio' => 'EL NARANJO',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            300 => 
            array (
                'id' => 58,
                'municipio' => 'MATLAPA',
                'id_estado' => 24,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            301 => 
            array (
                'id' => 1,
                'municipio' => 'AHOME',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            302 => 
            array (
                'id' => 2,
                'municipio' => 'ANGOSTURA',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            303 => 
            array (
                'id' => 3,
                'municipio' => 'BADIRAGUATO',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            304 => 
            array (
                'id' => 4,
                'municipio' => 'CONCORDIA',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            305 => 
            array (
                'id' => 5,
                'municipio' => 'COSALA',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            306 => 
            array (
                'id' => 6,
                'municipio' => 'CULIACAN',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            307 => 
            array (
                'id' => 7,
                'municipio' => 'CHOIX',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            308 => 
            array (
                'id' => 8,
                'municipio' => 'ELOTA',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            309 => 
            array (
                'id' => 9,
                'municipio' => 'ESCUINAPA',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            310 => 
            array (
                'id' => 10,
                'municipio' => 'EL FUERTE',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            311 => 
            array (
                'id' => 11,
                'municipio' => 'GUASAVE',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            312 => 
            array (
                'id' => 12,
                'municipio' => 'MAZATLAN',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            313 => 
            array (
                'id' => 13,
                'municipio' => 'MOCORITO',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            314 => 
            array (
                'id' => 14,
                'municipio' => 'ROSARIO',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            315 => 
            array (
                'id' => 15,
                'municipio' => 'SALVADOR ALVARADO',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            316 => 
            array (
                'id' => 16,
                'municipio' => 'SAN IGNACIO',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            317 => 
            array (
                'id' => 17,
                'municipio' => 'SINALOA',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            318 => 
            array (
                'id' => 18,
                'municipio' => 'NAVOLATO',
                'id_estado' => 25,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            319 => 
            array (
                'id' => 1,
                'municipio' => 'ACONCHI',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            320 => 
            array (
                'id' => 2,
                'municipio' => 'AGUA PRIETA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            321 => 
            array (
                'id' => 3,
                'municipio' => 'ALTAR',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            322 => 
            array (
                'id' => 4,
                'municipio' => 'ARIVECHI',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            323 => 
            array (
                'id' => 5,
                'municipio' => 'ARIZPE',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            324 => 
            array (
                'id' => 6,
                'municipio' => 'ATIL',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            325 => 
            array (
                'id' => 7,
                'municipio' => 'BACADEHUACHI',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            326 => 
            array (
                'id' => 8,
                'municipio' => 'BACANORA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            327 => 
            array (
                'id' => 9,
                'municipio' => 'BACERAC',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            328 => 
            array (
                'id' => 10,
                'municipio' => 'BACOACHI',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            329 => 
            array (
                'id' => 11,
                'municipio' => 'BANAMICHI',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            330 => 
            array (
                'id' => 12,
                'municipio' => 'BAVIACORA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            331 => 
            array (
                'id' => 13,
                'municipio' => 'BAVISPE',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            332 => 
            array (
                'id' => 14,
                'municipio' => 'BENJAMIN HILL',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            333 => 
            array (
                'id' => 15,
                'municipio' => 'CANANEA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            334 => 
            array (
                'id' => 16,
                'municipio' => 'CUCURPE',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            335 => 
            array (
                'id' => 17,
                'municipio' => 'CUMPAS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            336 => 
            array (
                'id' => 18,
                'municipio' => 'DIVISADEROS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            337 => 
            array (
                'id' => 19,
                'municipio' => 'FRONTERAS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            338 => 
            array (
                'id' => 20,
                'municipio' => 'GRANADOS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            339 => 
            array (
                'id' => 21,
                'municipio' => 'HUACHINERA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            340 => 
            array (
                'id' => 22,
                'municipio' => 'HUASABAS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            341 => 
            array (
                'id' => 23,
                'municipio' => 'HUEPAC',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            342 => 
            array (
                'id' => 24,
                'municipio' => 'IMURIS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            343 => 
            array (
                'id' => 25,
                'municipio' => 'MAGDALENA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            344 => 
            array (
                'id' => 26,
                'municipio' => 'MOCTEZUMA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            345 => 
            array (
                'id' => 27,
                'municipio' => 'NACO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            346 => 
            array (
                'id' => 28,
                'municipio' => 'NACORI CHICO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            347 => 
            array (
                'id' => 29,
                'municipio' => 'NACOZARI DE GARCIA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            348 => 
            array (
                'id' => 30,
                'municipio' => 'NOGALES',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            349 => 
            array (
                'id' => 31,
                'municipio' => 'OQUITOA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            350 => 
            array (
                'id' => 32,
                'municipio' => 'SAHUARIPA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            351 => 
            array (
                'id' => 33,
                'municipio' => 'SAN FELIPE DE JESUS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            352 => 
            array (
                'id' => 34,
                'municipio' => 'SAN JAVIER',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            353 => 
            array (
                'id' => 35,
                'municipio' => 'SAN PEDRO DE LA CUEVA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            354 => 
            array (
                'id' => 36,
                'municipio' => 'SANTA ANA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            355 => 
            array (
                'id' => 37,
                'municipio' => 'SANTA CRUZ',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            356 => 
            array (
                'id' => 38,
                'municipio' => 'SARIC',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            357 => 
            array (
                'id' => 39,
                'municipio' => 'SOYOPA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            358 => 
            array (
                'id' => 40,
                'municipio' => 'SUAQUI GRANDE',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            359 => 
            array (
                'id' => 41,
                'municipio' => 'TEPACHE',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            360 => 
            array (
                'id' => 42,
                'municipio' => 'TRINCHERAS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            361 => 
            array (
                'id' => 43,
                'municipio' => 'TUBUTAMA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            362 => 
            array (
                'id' => 44,
                'municipio' => 'VILLA HIDALGO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            363 => 
            array (
                'id' => 45,
                'municipio' => 'VILLA PESQUEIRA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            364 => 
            array (
                'id' => 46,
                'municipio' => 'CABORCA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            365 => 
            array (
                'id' => 47,
                'municipio' => 'CARBO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            366 => 
            array (
                'id' => 48,
                'municipio' => 'LA COLORADA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            367 => 
            array (
                'id' => 49,
                'municipio' => 'HERMOSILLO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            368 => 
            array (
                'id' => 50,
                'municipio' => 'MAZATAN',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            369 => 
            array (
                'id' => 51,
                'municipio' => 'OPODEPE',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            370 => 
            array (
                'id' => 52,
                'municipio' => 'PITIQUITO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            371 => 
            array (
                'id' => 53,
                'municipio' => 'PUERTO PEÐASCO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            372 => 
            array (
                'id' => 54,
                'municipio' => 'RAYON',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            373 => 
            array (
                'id' => 55,
                'municipio' => 'SAN LUIS RIO COLORADO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            374 => 
            array (
                'id' => 56,
                'municipio' => 'SAN MIGUEL DE HORCASITAS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            375 => 
            array (
                'id' => 57,
                'municipio' => 'URES',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            376 => 
            array (
                'id' => 58,
                'municipio' => 'BACUM',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            377 => 
            array (
                'id' => 59,
                'municipio' => 'CAJEME',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            378 => 
            array (
                'id' => 60,
                'municipio' => 'EMPALME',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            379 => 
            array (
                'id' => 61,
                'municipio' => 'GUAYMAS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            380 => 
            array (
                'id' => 62,
                'municipio' => 'ALAMOS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            381 => 
            array (
                'id' => 63,
                'municipio' => 'ETCHOJOA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            382 => 
            array (
                'id' => 64,
                'municipio' => 'HUATABAMPO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            383 => 
            array (
                'id' => 65,
                'municipio' => 'NAVOJOA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            384 => 
            array (
                'id' => 66,
                'municipio' => 'ONAVAS',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            385 => 
            array (
                'id' => 67,
                'municipio' => 'QUIRIEGO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            386 => 
            array (
                'id' => 68,
                'municipio' => 'ROSARIO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            387 => 
            array (
                'id' => 69,
                'municipio' => 'YECORA',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            388 => 
            array (
                'id' => 70,
                'municipio' => 'GENERAL PLUTARCO ELIAS CALLES',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            389 => 
            array (
                'id' => 71,
                'municipio' => 'BENITO JUAREZ',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            390 => 
            array (
                'id' => 72,
                'municipio' => 'SAN IGNACIO RIO MUERTO',
                'id_estado' => 26,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            391 => 
            array (
                'id' => 1,
                'municipio' => 'BALANCAN',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            392 => 
            array (
                'id' => 2,
                'municipio' => 'CARDENAS',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            393 => 
            array (
                'id' => 3,
                'municipio' => 'CENTLA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            394 => 
            array (
                'id' => 4,
                'municipio' => 'CENTRO',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            395 => 
            array (
                'id' => 5,
                'municipio' => 'COMALCALCO',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            396 => 
            array (
                'id' => 6,
                'municipio' => 'CUNDUACAN',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            397 => 
            array (
                'id' => 7,
                'municipio' => 'EMILIANO ZAPATA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            398 => 
            array (
                'id' => 8,
                'municipio' => 'HUIMANGUILLO',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            399 => 
            array (
                'id' => 9,
                'municipio' => 'JALAPA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            400 => 
            array (
                'id' => 10,
                'municipio' => 'JALPA DE MENDEZ',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            401 => 
            array (
                'id' => 11,
                'municipio' => 'JONUTA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            402 => 
            array (
                'id' => 12,
                'municipio' => 'MACUSPANA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            403 => 
            array (
                'id' => 13,
                'municipio' => 'NACAJUCA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            404 => 
            array (
                'id' => 14,
                'municipio' => 'PARAISO',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            405 => 
            array (
                'id' => 15,
                'municipio' => 'TACOTALPA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            406 => 
            array (
                'id' => 16,
                'municipio' => 'TEAPA',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            407 => 
            array (
                'id' => 17,
                'municipio' => 'TENOSIQUE',
                'id_estado' => 27,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            408 => 
            array (
                'id' => 1,
                'municipio' => 'ABASOLO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            409 => 
            array (
                'id' => 2,
                'municipio' => 'ALDAMA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            410 => 
            array (
                'id' => 3,
                'municipio' => 'ALTAMIRA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            411 => 
            array (
                'id' => 4,
                'municipio' => 'ANTIGUO MORELOS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            412 => 
            array (
                'id' => 5,
                'municipio' => 'BURGOS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            413 => 
            array (
                'id' => 6,
                'municipio' => 'BUSTAMANTE',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            414 => 
            array (
                'id' => 7,
                'municipio' => 'CAMARGO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            415 => 
            array (
                'id' => 8,
                'municipio' => 'CASAS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            416 => 
            array (
                'id' => 9,
                'municipio' => 'CIUDAD MADERO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            417 => 
            array (
                'id' => 10,
                'municipio' => 'CRUILLAS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            418 => 
            array (
                'id' => 11,
                'municipio' => 'GOMEZ FARIAS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            419 => 
            array (
                'id' => 12,
                'municipio' => 'GONZALEZ',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            420 => 
            array (
                'id' => 13,
                'municipio' => 'G▄EMEZ',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            421 => 
            array (
                'id' => 14,
                'municipio' => 'GUERRERO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            422 => 
            array (
                'id' => 15,
                'municipio' => 'GUSTAVO DIAZ ORDAZ',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            423 => 
            array (
                'id' => 16,
                'municipio' => 'HIDALGO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            424 => 
            array (
                'id' => 17,
                'municipio' => 'JAUMAVE',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            425 => 
            array (
                'id' => 18,
                'municipio' => 'JIMENEZ',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            426 => 
            array (
                'id' => 19,
                'municipio' => 'LLERA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            427 => 
            array (
                'id' => 20,
                'municipio' => 'MAINERO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            428 => 
            array (
                'id' => 21,
                'municipio' => 'EL MANTE',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            429 => 
            array (
                'id' => 22,
                'municipio' => 'MATAMOROS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            430 => 
            array (
                'id' => 23,
                'municipio' => 'MENDEZ',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            431 => 
            array (
                'id' => 24,
                'municipio' => 'MIER',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            432 => 
            array (
                'id' => 25,
                'municipio' => 'MIGUEL ALEMAN',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            433 => 
            array (
                'id' => 26,
                'municipio' => 'MIQUIHUANA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            434 => 
            array (
                'id' => 27,
                'municipio' => 'NUEVO LAREDO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            435 => 
            array (
                'id' => 28,
                'municipio' => 'NUEVO MORELOS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            436 => 
            array (
                'id' => 29,
                'municipio' => 'OCAMPO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            437 => 
            array (
                'id' => 30,
                'municipio' => 'PADILLA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            438 => 
            array (
                'id' => 31,
                'municipio' => 'PALMILLAS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            439 => 
            array (
                'id' => 32,
                'municipio' => 'REYNOSA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            440 => 
            array (
                'id' => 33,
                'municipio' => 'RIO BRAVO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            441 => 
            array (
                'id' => 34,
                'municipio' => 'SAN CARLOS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            442 => 
            array (
                'id' => 35,
                'municipio' => 'SAN FERNANDO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            443 => 
            array (
                'id' => 36,
                'municipio' => 'SAN NICOLAS',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            444 => 
            array (
                'id' => 37,
                'municipio' => 'SOTO LA MARINA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            445 => 
            array (
                'id' => 38,
                'municipio' => 'TAMPICO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            446 => 
            array (
                'id' => 39,
                'municipio' => 'TULA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            447 => 
            array (
                'id' => 40,
                'municipio' => 'VALLE HERMOSO',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            448 => 
            array (
                'id' => 41,
                'municipio' => 'VICTORIA',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            449 => 
            array (
                'id' => 42,
                'municipio' => 'VILLAGRAN',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            450 => 
            array (
                'id' => 43,
                'municipio' => 'XICOTENCATL',
                'id_estado' => 28,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            451 => 
            array (
                'id' => 1,
                'municipio' => 'AMAXAC DE GUERRERO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            452 => 
            array (
                'id' => 2,
                'municipio' => 'APETATITLAN DE ANTONIO CARVAJAL',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            453 => 
            array (
                'id' => 3,
                'municipio' => 'APIZACO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            454 => 
            array (
                'id' => 4,
                'municipio' => 'ATLANGATEPEC',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            455 => 
            array (
                'id' => 5,
                'municipio' => 'ALTZAYANCA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            456 => 
            array (
                'id' => 6,
                'municipio' => 'CALPULALPAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            457 => 
            array (
                'id' => 7,
                'municipio' => 'EL CARMEN TEQUEXQUITLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            458 => 
            array (
                'id' => 8,
                'municipio' => 'CUAPIAXTLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            459 => 
            array (
                'id' => 9,
                'municipio' => 'CUAXOMULCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            460 => 
            array (
                'id' => 10,
                'municipio' => 'CHIAUTEMPAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            461 => 
            array (
                'id' => 11,
                'municipio' => 'MUÐOZ DE DOMINGO ARENAS',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            462 => 
            array (
                'id' => 12,
                'municipio' => 'ESPAÐITA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            463 => 
            array (
                'id' => 13,
                'municipio' => 'HUAMANTLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            464 => 
            array (
                'id' => 14,
                'municipio' => 'HUEYOTLIPAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            465 => 
            array (
                'id' => 15,
                'municipio' => 'IXTACUIXTLA DE MARIANO MATAMOROS',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            466 => 
            array (
                'id' => 16,
                'municipio' => 'IXTENCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            467 => 
            array (
                'id' => 17,
                'municipio' => 'MAZATECOCHCO DE JOSE MARIA MORELOS',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            468 => 
            array (
                'id' => 18,
                'municipio' => 'CONTLA DE JUAN CUAMATZI',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            469 => 
            array (
                'id' => 19,
                'municipio' => 'TEPETITLA DE LARDIZABAL',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            470 => 
            array (
                'id' => 20,
                'municipio' => 'SANCTORUM DE LAZARO CARDENAS',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            471 => 
            array (
                'id' => 21,
                'municipio' => 'NANACAMILPA DE MARIANO ARISTA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            472 => 
            array (
                'id' => 22,
                'municipio' => 'ACUAMANALA DE MIGUEL HIDALGO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            473 => 
            array (
                'id' => 23,
                'municipio' => 'NATIVITAS',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            474 => 
            array (
                'id' => 24,
                'municipio' => 'PANOTLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            475 => 
            array (
                'id' => 25,
                'municipio' => 'SAN PABLO DEL MONTE',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            476 => 
            array (
                'id' => 26,
                'municipio' => 'SANTA CRUZ TLAXCALA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            477 => 
            array (
                'id' => 27,
                'municipio' => 'TENANCINGO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            478 => 
            array (
                'id' => 28,
                'municipio' => 'TEOLOCHOLCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            479 => 
            array (
                'id' => 29,
                'municipio' => 'TEPEYANCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            480 => 
            array (
                'id' => 30,
                'municipio' => 'TERRENATE',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            481 => 
            array (
                'id' => 31,
                'municipio' => 'TETLA DE LA SOLIDARIDAD',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            482 => 
            array (
                'id' => 32,
                'municipio' => 'TETLATLAHUCA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            483 => 
            array (
                'id' => 33,
                'municipio' => 'TLAXCALA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            484 => 
            array (
                'id' => 34,
                'municipio' => 'TLAXCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            485 => 
            array (
                'id' => 35,
                'municipio' => 'TOCATLAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            486 => 
            array (
                'id' => 36,
                'municipio' => 'TOTOLAC',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            487 => 
            array (
                'id' => 37,
                'municipio' => 'ZITLALTEPEC DE TRINIDAD SANCHEZ SANTOS',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            488 => 
            array (
                'id' => 38,
                'municipio' => 'TZOMPANTEPEC',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            489 => 
            array (
                'id' => 39,
                'municipio' => 'XALOZTOC',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            490 => 
            array (
                'id' => 40,
                'municipio' => 'XALTOCAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            491 => 
            array (
                'id' => 41,
                'municipio' => 'PAPALOTLA DE XICOHTENCATL',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            492 => 
            array (
                'id' => 42,
                'municipio' => 'XICOHTZINCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            493 => 
            array (
                'id' => 43,
                'municipio' => 'YAUHQUEMECAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            494 => 
            array (
                'id' => 44,
                'municipio' => 'ZACATELCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            495 => 
            array (
                'id' => 45,
                'municipio' => 'SANTA APOLONIA TEACALCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            496 => 
            array (
                'id' => 46,
                'municipio' => 'SANTA CRUZ QUILEHTLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            497 => 
            array (
                'id' => 47,
                'municipio' => 'SAN JUAN HUACTZINCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            498 => 
            array (
                'id' => 48,
                'municipio' => 'SANTA CATARINA AYOMETLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            499 => 
            array (
                'id' => 49,
                'municipio' => 'SANTA ISABEL XILOXOXTLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        \DB::table('cat_municipios')->insert(array (
            0 => 
            array (
                'id' => 50,
                'municipio' => 'SAN JOSE TEACALCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 51,
                'municipio' => 'SAN FRANCISCO TETLANOHCAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 52,
                'municipio' => 'LA MAGDALENA TLALTELULCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 53,
                'municipio' => 'SAN DAMIAN TEXOLOC',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 54,
                'municipio' => 'EMILIANO ZAPATA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 55,
                'municipio' => 'LAZARO CARDENAS',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 56,
                'municipio' => 'SAN JERONIMO ZACUALPAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 57,
                'municipio' => 'SAN LUCAS TECOPILCO',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 58,
                'municipio' => 'SANTA ANA NOPALUCAN',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 59,
                'municipio' => 'SAN LORENZO AXOCOMANITLA',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 60,
                'municipio' => 'BENITO JUAREZ',
                'id_estado' => 29,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 1,
                'municipio' => 'ACAJETE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 2,
                'municipio' => 'ACATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 3,
                'municipio' => 'ACAYUCAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 4,
                'municipio' => 'ACTOPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 5,
                'municipio' => 'ACULA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 6,
                'municipio' => 'ACULTZINGO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 7,
                'municipio' => 'CAMARON DE TEJEDA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 8,
                'municipio' => 'ALAMO TEMAPACHE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 9,
                'municipio' => 'ALPATLAHUAC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 10,
                'municipio' => 'ALTO LUCERO DE GUTIERREZ BARRIOS',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 11,
                'municipio' => 'ALTOTONGA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 12,
                'municipio' => 'ALVARADO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 13,
                'municipio' => 'AMATITLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 14,
                'municipio' => 'AMATLAN DE LOS REYES',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 15,
                'municipio' => 'NARANJOS AMATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 16,
                'municipio' => 'ANGEL R. CABADA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 17,
                'municipio' => 'LA ANTIGUA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 18,
                'municipio' => 'APAZAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 19,
                'municipio' => 'AQUILA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 20,
                'municipio' => 'ASTACINGA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 21,
                'municipio' => 'ATLAHUILCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 22,
                'municipio' => 'ATOYAC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 23,
                'municipio' => 'ATZACAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 24,
                'municipio' => 'ATZALAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 25,
                'municipio' => 'TLALTETELA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 26,
                'municipio' => 'AYAHUALULCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 27,
                'municipio' => 'BANDERILLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 28,
                'municipio' => 'BENITO JUAREZ',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 29,
                'municipio' => 'BOCA DEL RIO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 30,
                'municipio' => 'CALCAHUALCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 31,
                'municipio' => 'CAMERINO Z. MENDOZA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 32,
                'municipio' => 'CARRILLO PUERTO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 33,
                'municipio' => 'CASTILLO DE TEAYO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 34,
                'municipio' => 'CATEMACO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 35,
                'municipio' => 'CAZONES DE HERRERA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 36,
                'municipio' => 'CERRO AZUL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 37,
                'municipio' => 'CITLALTEPETL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 38,
                'municipio' => 'COACOATZINTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 39,
                'municipio' => 'COAHUITLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 40,
                'municipio' => 'COATEPEC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 41,
                'municipio' => 'COATZACOALCOS',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 42,
                'municipio' => 'COATZINTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 43,
                'municipio' => 'COETZALA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 44,
                'municipio' => 'COLIPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 45,
                'municipio' => 'COMAPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 46,
                'municipio' => 'CORDOBA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 47,
                'municipio' => 'COSAMALOAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 48,
                'municipio' => 'COSAUTLAN DE CARVAJAL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 49,
                'municipio' => 'COSCOMATEPEC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 50,
                'municipio' => 'COSOLEACAQUE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 51,
                'municipio' => 'COTAXTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 52,
                'municipio' => 'COXQUIHUI',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 53,
                'municipio' => 'COYUTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 54,
                'municipio' => 'CUICHAPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 55,
                'municipio' => 'CUITLAHUAC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 56,
                'municipio' => 'CHACALTIANGUIS',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 57,
                'municipio' => 'CHALMA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 58,
                'municipio' => 'CHICONAMEL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 59,
                'municipio' => 'CHICONQUIACO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 60,
                'municipio' => 'CHICONTEPEC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 61,
                'municipio' => 'CHINAMECA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 62,
                'municipio' => 'CHINAMPA DE GOROSTIZA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 63,
                'municipio' => 'LAS CHOAPAS',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 64,
                'municipio' => 'CHOCAMAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 65,
                'municipio' => 'CHONTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 66,
                'municipio' => 'CHUMATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 67,
                'municipio' => 'EMILIANO ZAPATA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 68,
                'municipio' => 'ESPINAL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 69,
                'municipio' => 'FILOMENO MATA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 70,
                'municipio' => 'FORTIN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 71,
                'municipio' => 'GUTIERREZ ZAMORA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 72,
                'municipio' => 'HIDALGOTITLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 73,
                'municipio' => 'HUATUSCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 74,
                'municipio' => 'HUAYACOCOTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 75,
                'municipio' => 'HUEYAPAN DE OCAMPO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 76,
                'municipio' => 'HUILOAPAN DE CUAUHTEMOC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 77,
                'municipio' => 'IGNACIO DE LA LLAVE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 78,
                'municipio' => 'ILAMATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 79,
                'municipio' => 'ISLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 80,
                'municipio' => 'IXCATEPEC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 81,
                'municipio' => 'IXHUACAN DE LOS REYES',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 82,
                'municipio' => 'IXHUATLAN DE MADERO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 83,
                'municipio' => 'IXHUATLAN DEL CAFE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 => 
            array (
                'id' => 84,
                'municipio' => 'IXHUATLAN DEL SURESTE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 => 
            array (
                'id' => 85,
                'municipio' => 'IXHUATLANCILLO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 => 
            array (
                'id' => 86,
                'municipio' => 'IXMATLAHUACAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 => 
            array (
                'id' => 87,
                'municipio' => 'IXTACZOQUITLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 => 
            array (
                'id' => 88,
                'municipio' => 'JALACINGO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 => 
            array (
                'id' => 89,
                'municipio' => 'XALAPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 => 
            array (
                'id' => 90,
                'municipio' => 'JALCOMULCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 => 
            array (
                'id' => 91,
                'municipio' => 'JALTIPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 => 
            array (
                'id' => 92,
                'municipio' => 'JAMAPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 => 
            array (
                'id' => 93,
                'municipio' => 'JESUS CARRANZA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 => 
            array (
                'id' => 94,
                'municipio' => 'JILOTEPEC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 => 
            array (
                'id' => 95,
                'municipio' => 'JUAN RODRIGUEZ CLARA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 => 
            array (
                'id' => 96,
                'municipio' => 'JUCHIQUE DE FERRER',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 => 
            array (
                'id' => 97,
                'municipio' => 'LANDERO Y COSS',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 => 
            array (
                'id' => 98,
                'municipio' => 'LERDO DE TEJADA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 => 
            array (
                'id' => 99,
                'municipio' => 'MAGDALENA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 => 
            array (
                'id' => 100,
                'municipio' => 'MALTRATA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 => 
            array (
                'id' => 101,
                'municipio' => 'MANLIO FABIO ALTAMIRANO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 => 
            array (
                'id' => 102,
                'municipio' => 'MARIANO ESCOBEDO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 => 
            array (
                'id' => 103,
                'municipio' => 'MARTINEZ DE LA TORRE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            114 => 
            array (
                'id' => 104,
                'municipio' => 'MECATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            115 => 
            array (
                'id' => 105,
                'municipio' => 'MECAYAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            116 => 
            array (
                'id' => 106,
                'municipio' => 'MEDELLIN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            117 => 
            array (
                'id' => 107,
                'municipio' => 'MIAHUATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            118 => 
            array (
                'id' => 108,
                'municipio' => 'LAS MINAS',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            119 => 
            array (
                'id' => 109,
                'municipio' => 'MINATITLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            120 => 
            array (
                'id' => 110,
                'municipio' => 'MISANTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            121 => 
            array (
                'id' => 111,
                'municipio' => 'MIXTLA DE ALTAMIRANO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            122 => 
            array (
                'id' => 112,
                'municipio' => 'MOLOACAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            123 => 
            array (
                'id' => 113,
                'municipio' => 'NAOLINCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            124 => 
            array (
                'id' => 114,
                'municipio' => 'NARANJAL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            125 => 
            array (
                'id' => 115,
                'municipio' => 'NAUTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            126 => 
            array (
                'id' => 116,
                'municipio' => 'NOGALES',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            127 => 
            array (
                'id' => 117,
                'municipio' => 'OLUTA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            128 => 
            array (
                'id' => 118,
                'municipio' => 'OMEALCA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            129 => 
            array (
                'id' => 119,
                'municipio' => 'ORIZABA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            130 => 
            array (
                'id' => 120,
                'municipio' => 'OTATITLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            131 => 
            array (
                'id' => 121,
                'municipio' => 'OTEAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            132 => 
            array (
                'id' => 122,
                'municipio' => 'OZULUAMA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            133 => 
            array (
                'id' => 123,
                'municipio' => 'PAJAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            134 => 
            array (
                'id' => 124,
                'municipio' => 'PANUCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            135 => 
            array (
                'id' => 125,
                'municipio' => 'PAPANTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            136 => 
            array (
                'id' => 126,
                'municipio' => 'PASO DEL MACHO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            137 => 
            array (
                'id' => 127,
                'municipio' => 'PASO DE OVEJAS',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            138 => 
            array (
                'id' => 128,
                'municipio' => 'LA PERLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            139 => 
            array (
                'id' => 129,
                'municipio' => 'PEROTE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            140 => 
            array (
                'id' => 130,
                'municipio' => 'PLATON SANCHEZ',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            141 => 
            array (
                'id' => 131,
                'municipio' => 'PLAYA VICENTE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            142 => 
            array (
                'id' => 132,
                'municipio' => 'POZA RICA DE HIDALGO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            143 => 
            array (
                'id' => 133,
                'municipio' => 'PUEBLO VIEJO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            144 => 
            array (
                'id' => 134,
                'municipio' => 'PUENTE NACIONAL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            145 => 
            array (
                'id' => 135,
                'municipio' => 'RAFAEL DELGADO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            146 => 
            array (
                'id' => 136,
                'municipio' => 'RAFAEL LUCIO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            147 => 
            array (
                'id' => 137,
                'municipio' => 'LAS VIGAS DE RAMIREZ',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            148 => 
            array (
                'id' => 138,
                'municipio' => 'LOS REYES',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            149 => 
            array (
                'id' => 139,
                'municipio' => 'RIO BLANCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            150 => 
            array (
                'id' => 140,
                'municipio' => 'SALTABARRANCA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            151 => 
            array (
                'id' => 141,
                'municipio' => 'SAN ANDRES TENEJAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            152 => 
            array (
                'id' => 142,
                'municipio' => 'SAN ANDRES TUXTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            153 => 
            array (
                'id' => 143,
                'municipio' => 'SAN JUAN EVANGELISTA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            154 => 
            array (
                'id' => 144,
                'municipio' => 'SANTIAGO TUXTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            155 => 
            array (
                'id' => 145,
                'municipio' => 'SAYULA DE ALEMAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            156 => 
            array (
                'id' => 146,
                'municipio' => 'SOCONUSCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            157 => 
            array (
                'id' => 147,
                'municipio' => 'SOCHIAPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            158 => 
            array (
                'id' => 148,
                'municipio' => 'SOLEDAD ATZOMPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            159 => 
            array (
                'id' => 149,
                'municipio' => 'SOLEDAD DE DOBLADO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            160 => 
            array (
                'id' => 150,
                'municipio' => 'SOTEAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            161 => 
            array (
                'id' => 151,
                'municipio' => 'TAMALIN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            162 => 
            array (
                'id' => 152,
                'municipio' => 'TAMIAHUA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            163 => 
            array (
                'id' => 153,
                'municipio' => 'TAMPICO ALTO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            164 => 
            array (
                'id' => 154,
                'municipio' => 'TANCOCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            165 => 
            array (
                'id' => 155,
                'municipio' => 'TANTIMA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            166 => 
            array (
                'id' => 156,
                'municipio' => 'TANTOYUCA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            167 => 
            array (
                'id' => 157,
                'municipio' => 'TATATILA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            168 => 
            array (
                'id' => 158,
                'municipio' => 'TECOLUTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            169 => 
            array (
                'id' => 159,
                'municipio' => 'TEHUIPANGO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            170 => 
            array (
                'id' => 160,
                'municipio' => 'TEMPOAL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            171 => 
            array (
                'id' => 161,
                'municipio' => 'TENAMPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            172 => 
            array (
                'id' => 162,
                'municipio' => 'TENOCHTITLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            173 => 
            array (
                'id' => 163,
                'municipio' => 'TEOCELO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            174 => 
            array (
                'id' => 164,
                'municipio' => 'TEPATLAXCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            175 => 
            array (
                'id' => 165,
                'municipio' => 'TEPETLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            176 => 
            array (
                'id' => 166,
                'municipio' => 'TEPETZINTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            177 => 
            array (
                'id' => 167,
                'municipio' => 'TEQUILA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            178 => 
            array (
                'id' => 168,
                'municipio' => 'JOSE AZUETA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            179 => 
            array (
                'id' => 169,
                'municipio' => 'TEXCATEPEC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            180 => 
            array (
                'id' => 170,
                'municipio' => 'TEXHUACAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            181 => 
            array (
                'id' => 171,
                'municipio' => 'TEXISTEPEC',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            182 => 
            array (
                'id' => 172,
                'municipio' => 'TEZONAPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            183 => 
            array (
                'id' => 173,
                'municipio' => 'TIERRA BLANCA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            184 => 
            array (
                'id' => 174,
                'municipio' => 'TIHUATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            185 => 
            array (
                'id' => 175,
                'municipio' => 'TLACOJALPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            186 => 
            array (
                'id' => 176,
                'municipio' => 'TLACOLULAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            187 => 
            array (
                'id' => 177,
                'municipio' => 'TLACOTALPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            188 => 
            array (
                'id' => 178,
                'municipio' => 'TLACOTEPEC DE MEJIA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            189 => 
            array (
                'id' => 179,
                'municipio' => 'TLACHICHILCO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            190 => 
            array (
                'id' => 180,
                'municipio' => 'TLALIXCOYAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            191 => 
            array (
                'id' => 181,
                'municipio' => 'TLALNELHUAYOCAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            192 => 
            array (
                'id' => 182,
                'municipio' => 'TLAPACOYAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            193 => 
            array (
                'id' => 183,
                'municipio' => 'TLAQUILPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            194 => 
            array (
                'id' => 184,
                'municipio' => 'TLILAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            195 => 
            array (
                'id' => 185,
                'municipio' => 'TOMATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            196 => 
            array (
                'id' => 186,
                'municipio' => 'TONAYAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            197 => 
            array (
                'id' => 187,
                'municipio' => 'TOTUTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            198 => 
            array (
                'id' => 188,
                'municipio' => 'TUXPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            199 => 
            array (
                'id' => 189,
                'municipio' => 'TUXTILLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            200 => 
            array (
                'id' => 190,
                'municipio' => 'URSULO GALVAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            201 => 
            array (
                'id' => 191,
                'municipio' => 'VEGA DE ALATORRE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            202 => 
            array (
                'id' => 192,
                'municipio' => 'VERACRUZ',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            203 => 
            array (
                'id' => 193,
                'municipio' => 'VILLA ALDAMA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            204 => 
            array (
                'id' => 194,
                'municipio' => 'XICO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            205 => 
            array (
                'id' => 195,
                'municipio' => 'XOXOCOTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            206 => 
            array (
                'id' => 196,
                'municipio' => 'YANGA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            207 => 
            array (
                'id' => 197,
                'municipio' => 'YECUATLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            208 => 
            array (
                'id' => 198,
                'municipio' => 'ZACUALPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            209 => 
            array (
                'id' => 199,
                'municipio' => 'ZARAGOZA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            210 => 
            array (
                'id' => 200,
                'municipio' => 'ZENTLA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            211 => 
            array (
                'id' => 201,
                'municipio' => 'ZONGOLICA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            212 => 
            array (
                'id' => 202,
                'municipio' => 'ZONTECOMATLAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            213 => 
            array (
                'id' => 203,
                'municipio' => 'ZOZOCOLCO DE HIDALGO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            214 => 
            array (
                'id' => 204,
                'municipio' => 'TRES VALLES',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            215 => 
            array (
                'id' => 205,
                'municipio' => 'NANCHITAL DE LAZARO CARDENAS DEL RIO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            216 => 
            array (
                'id' => 206,
                'municipio' => 'AGUA DULCE',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            217 => 
            array (
                'id' => 207,
                'municipio' => 'EL HIGO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            218 => 
            array (
                'id' => 208,
                'municipio' => 'CARLOS A. CARRILLO',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            219 => 
            array (
                'id' => 209,
                'municipio' => 'UXPANAPA',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            220 => 
            array (
                'id' => 210,
                'municipio' => 'TATAHUICAPAN DE JUAREZ',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            221 => 
            array (
                'id' => 211,
                'municipio' => 'SAN RAFAEL',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            222 => 
            array (
                'id' => 212,
                'municipio' => 'SANTIAGO SOCHIAPAN',
                'id_estado' => 30,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            223 => 
            array (
                'id' => 1,
                'municipio' => 'ABALA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            224 => 
            array (
                'id' => 2,
                'municipio' => 'ACANCEH',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            225 => 
            array (
                'id' => 3,
                'municipio' => 'AKIL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            226 => 
            array (
                'id' => 4,
                'municipio' => 'BACA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            227 => 
            array (
                'id' => 5,
                'municipio' => 'BOKOBA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            228 => 
            array (
                'id' => 6,
                'municipio' => 'BUCTZOTZ',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            229 => 
            array (
                'id' => 7,
                'municipio' => 'CACALCHEN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            230 => 
            array (
                'id' => 8,
                'municipio' => 'CALOTMUL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            231 => 
            array (
                'id' => 9,
                'municipio' => 'CANSAHCAB',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            232 => 
            array (
                'id' => 10,
                'municipio' => 'CANTAMAYEC',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            233 => 
            array (
                'id' => 11,
                'municipio' => 'CELESTUN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            234 => 
            array (
                'id' => 12,
                'municipio' => 'CENOTILLO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            235 => 
            array (
                'id' => 13,
                'municipio' => 'CONKAL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            236 => 
            array (
                'id' => 14,
                'municipio' => 'CUNCUNUL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            237 => 
            array (
                'id' => 15,
                'municipio' => 'CUZAMA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            238 => 
            array (
                'id' => 16,
                'municipio' => 'CHACSINKIN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            239 => 
            array (
                'id' => 17,
                'municipio' => 'CHANKOM',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            240 => 
            array (
                'id' => 18,
                'municipio' => 'CHAPAB',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            241 => 
            array (
                'id' => 19,
                'municipio' => 'CHEMAX',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            242 => 
            array (
                'id' => 20,
                'municipio' => 'CHICXULUB PUEBLO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            243 => 
            array (
                'id' => 21,
                'municipio' => 'CHICHIMILA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            244 => 
            array (
                'id' => 22,
                'municipio' => 'CHIKINDZONOT',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            245 => 
            array (
                'id' => 23,
                'municipio' => 'CHOCHOLA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            246 => 
            array (
                'id' => 24,
                'municipio' => 'CHUMAYEL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            247 => 
            array (
                'id' => 25,
                'municipio' => 'DZAN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            248 => 
            array (
                'id' => 26,
                'municipio' => 'DZEMUL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            249 => 
            array (
                'id' => 27,
                'municipio' => 'DZIDZANTUN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            250 => 
            array (
                'id' => 28,
                'municipio' => 'DZILAM DE BRAVO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            251 => 
            array (
                'id' => 29,
                'municipio' => 'DZILAM GONZALEZ',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            252 => 
            array (
                'id' => 30,
                'municipio' => 'DZITAS',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            253 => 
            array (
                'id' => 31,
                'municipio' => 'DZONCAUICH',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            254 => 
            array (
                'id' => 32,
                'municipio' => 'ESPITA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            255 => 
            array (
                'id' => 33,
                'municipio' => 'HALACHO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            256 => 
            array (
                'id' => 34,
                'municipio' => 'HOCABA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            257 => 
            array (
                'id' => 35,
                'municipio' => 'HOCTUN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            258 => 
            array (
                'id' => 36,
                'municipio' => 'HOMUN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            259 => 
            array (
                'id' => 37,
                'municipio' => 'HUHI',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            260 => 
            array (
                'id' => 38,
                'municipio' => 'HUNUCMA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            261 => 
            array (
                'id' => 39,
                'municipio' => 'IXIL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            262 => 
            array (
                'id' => 40,
                'municipio' => 'IZAMAL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            263 => 
            array (
                'id' => 41,
                'municipio' => 'KANASIN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            264 => 
            array (
                'id' => 42,
                'municipio' => 'KANTUNIL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            265 => 
            array (
                'id' => 43,
                'municipio' => 'KAUA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            266 => 
            array (
                'id' => 44,
                'municipio' => 'KINCHIL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            267 => 
            array (
                'id' => 45,
                'municipio' => 'KOPOMA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            268 => 
            array (
                'id' => 46,
                'municipio' => 'MAMA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            269 => 
            array (
                'id' => 47,
                'municipio' => 'MANI',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            270 => 
            array (
                'id' => 48,
                'municipio' => 'MAXCANU',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            271 => 
            array (
                'id' => 49,
                'municipio' => 'MAYAPAN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            272 => 
            array (
                'id' => 50,
                'municipio' => 'MERIDA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            273 => 
            array (
                'id' => 51,
                'municipio' => 'MOCOCHA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            274 => 
            array (
                'id' => 52,
                'municipio' => 'MOTUL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            275 => 
            array (
                'id' => 53,
                'municipio' => 'MUNA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            276 => 
            array (
                'id' => 54,
                'municipio' => 'MUXUPIP',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            277 => 
            array (
                'id' => 55,
                'municipio' => 'OPICHEN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            278 => 
            array (
                'id' => 56,
                'municipio' => 'OXKUTZCAB',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            279 => 
            array (
                'id' => 57,
                'municipio' => 'PANABA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            280 => 
            array (
                'id' => 58,
                'municipio' => 'PETO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            281 => 
            array (
                'id' => 59,
                'municipio' => 'PROGRESO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            282 => 
            array (
                'id' => 60,
                'municipio' => 'QUINTANA ROO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            283 => 
            array (
                'id' => 61,
                'municipio' => 'RIO LAGARTOS',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            284 => 
            array (
                'id' => 62,
                'municipio' => 'SACALUM',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            285 => 
            array (
                'id' => 63,
                'municipio' => 'SAMAHIL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            286 => 
            array (
                'id' => 64,
                'municipio' => 'SANAHCAT',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            287 => 
            array (
                'id' => 65,
                'municipio' => 'SAN FELIPE',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            288 => 
            array (
                'id' => 66,
                'municipio' => 'SANTA ELENA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            289 => 
            array (
                'id' => 67,
                'municipio' => 'SEYE',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            290 => 
            array (
                'id' => 68,
                'municipio' => 'SINANCHE',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            291 => 
            array (
                'id' => 69,
                'municipio' => 'SOTUTA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            292 => 
            array (
                'id' => 70,
                'municipio' => 'SUCILA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            293 => 
            array (
                'id' => 71,
                'municipio' => 'SUDZAL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            294 => 
            array (
                'id' => 72,
                'municipio' => 'SUMA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            295 => 
            array (
                'id' => 73,
                'municipio' => 'TAHDZIU',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            296 => 
            array (
                'id' => 74,
                'municipio' => 'TAHMEK',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            297 => 
            array (
                'id' => 75,
                'municipio' => 'TEABO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            298 => 
            array (
                'id' => 76,
                'municipio' => 'TECOH',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            299 => 
            array (
                'id' => 77,
                'municipio' => 'TEKAL DE VENEGAS',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            300 => 
            array (
                'id' => 78,
                'municipio' => 'TEKANTO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            301 => 
            array (
                'id' => 79,
                'municipio' => 'TEKAX',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            302 => 
            array (
                'id' => 80,
                'municipio' => 'TEKIT',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            303 => 
            array (
                'id' => 81,
                'municipio' => 'TEKOM',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            304 => 
            array (
                'id' => 82,
                'municipio' => 'TELCHAC PUEBLO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            305 => 
            array (
                'id' => 83,
                'municipio' => 'TELCHAC PUERTO',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            306 => 
            array (
                'id' => 84,
                'municipio' => 'TEMAX',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            307 => 
            array (
                'id' => 85,
                'municipio' => 'TEMOZON',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            308 => 
            array (
                'id' => 86,
                'municipio' => 'TEPAKAN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            309 => 
            array (
                'id' => 87,
                'municipio' => 'TETIZ',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            310 => 
            array (
                'id' => 88,
                'municipio' => 'TEYA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            311 => 
            array (
                'id' => 89,
                'municipio' => 'TICUL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            312 => 
            array (
                'id' => 90,
                'municipio' => 'TIMUCUY',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            313 => 
            array (
                'id' => 91,
                'municipio' => 'TINUM',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            314 => 
            array (
                'id' => 92,
                'municipio' => 'TIXCACALCUPUL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            315 => 
            array (
                'id' => 93,
                'municipio' => 'TIXKOKOB',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            316 => 
            array (
                'id' => 94,
                'municipio' => 'TIXMEHUAC',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            317 => 
            array (
                'id' => 95,
                'municipio' => 'TIXPEHUAL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            318 => 
            array (
                'id' => 96,
                'municipio' => 'TIZIMIN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            319 => 
            array (
                'id' => 97,
                'municipio' => 'TUNKAS',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            320 => 
            array (
                'id' => 98,
                'municipio' => 'TZUCACAB',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            321 => 
            array (
                'id' => 99,
                'municipio' => 'UAYMA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            322 => 
            array (
                'id' => 100,
                'municipio' => 'UCU',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            323 => 
            array (
                'id' => 101,
                'municipio' => 'UMAN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            324 => 
            array (
                'id' => 102,
                'municipio' => 'VALLADOLID',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            325 => 
            array (
                'id' => 103,
                'municipio' => 'XOCCHEL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            326 => 
            array (
                'id' => 104,
                'municipio' => 'YAXCABA',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            327 => 
            array (
                'id' => 105,
                'municipio' => 'YAXKUKUL',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            328 => 
            array (
                'id' => 106,
                'municipio' => 'YOBAIN',
                'id_estado' => 31,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            329 => 
            array (
                'id' => 1,
                'municipio' => 'APOZOL',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            330 => 
            array (
                'id' => 2,
                'municipio' => 'APULCO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            331 => 
            array (
                'id' => 3,
                'municipio' => 'ATOLINGA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            332 => 
            array (
                'id' => 4,
                'municipio' => 'BENITO JUAREZ',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            333 => 
            array (
                'id' => 5,
                'municipio' => 'CALERA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            334 => 
            array (
                'id' => 6,
                'municipio' => 'CAÐITAS DE FELIPE PESCADOR',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            335 => 
            array (
                'id' => 7,
                'municipio' => 'CONCEPCION DEL ORO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            336 => 
            array (
                'id' => 8,
                'municipio' => 'CUAUHTEMOC',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            337 => 
            array (
                'id' => 9,
                'municipio' => 'CHALCHIHUITES',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            338 => 
            array (
                'id' => 10,
                'municipio' => 'FRESNILLO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            339 => 
            array (
                'id' => 11,
                'municipio' => 'TRINIDAD GARCIA DE LA CADENA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            340 => 
            array (
                'id' => 12,
                'municipio' => 'GENARO CODINA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            341 => 
            array (
                'id' => 13,
                'municipio' => 'GENERAL ENRIQUE ESTRADA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            342 => 
            array (
                'id' => 14,
                'municipio' => 'GENERAL FRANCISCO R. MURGUIA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            343 => 
            array (
                'id' => 15,
                'municipio' => 'EL PLATEADO DE JOAQUIN AMARO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            344 => 
            array (
                'id' => 16,
                'municipio' => 'GENERAL PANFILO NATERA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            345 => 
            array (
                'id' => 17,
                'municipio' => 'GUADALUPE',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            346 => 
            array (
                'id' => 18,
                'municipio' => 'HUANUSCO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            347 => 
            array (
                'id' => 19,
                'municipio' => 'JALPA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            348 => 
            array (
                'id' => 20,
                'municipio' => 'JEREZ',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            349 => 
            array (
                'id' => 21,
                'municipio' => 'JIMENEZ DEL TEUL',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            350 => 
            array (
                'id' => 22,
                'municipio' => 'JUAN ALDAMA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            351 => 
            array (
                'id' => 23,
                'municipio' => 'JUCHIPILA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            352 => 
            array (
                'id' => 24,
                'municipio' => 'LORETO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            353 => 
            array (
                'id' => 25,
                'municipio' => 'LUIS MOYA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            354 => 
            array (
                'id' => 26,
                'municipio' => 'MAZAPIL',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            355 => 
            array (
                'id' => 27,
                'municipio' => 'MELCHOR OCAMPO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            356 => 
            array (
                'id' => 28,
                'municipio' => 'MEZQUITAL DEL ORO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            357 => 
            array (
                'id' => 29,
                'municipio' => 'MIGUEL AUZA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            358 => 
            array (
                'id' => 30,
                'municipio' => 'MOMAX',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            359 => 
            array (
                'id' => 31,
                'municipio' => 'MONTE ESCOBEDO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            360 => 
            array (
                'id' => 32,
                'municipio' => 'MORELOS',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            361 => 
            array (
                'id' => 33,
                'municipio' => 'MOYAHUA DE ESTRADA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            362 => 
            array (
                'id' => 34,
                'municipio' => 'NOCHISTLAN DE MEJIA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            363 => 
            array (
                'id' => 35,
                'municipio' => 'NORIA DE ANGELES',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            364 => 
            array (
                'id' => 36,
                'municipio' => 'OJOCALIENTE',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            365 => 
            array (
                'id' => 37,
                'municipio' => 'PANUCO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            366 => 
            array (
                'id' => 38,
                'municipio' => 'PINOS',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            367 => 
            array (
                'id' => 39,
                'municipio' => 'RIO GRANDE',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            368 => 
            array (
                'id' => 40,
                'municipio' => 'SAIN ALTO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            369 => 
            array (
                'id' => 41,
                'municipio' => 'EL SALVADOR',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            370 => 
            array (
                'id' => 42,
                'municipio' => 'SOMBRERETE',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            371 => 
            array (
                'id' => 43,
                'municipio' => 'SUSTICACAN',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            372 => 
            array (
                'id' => 44,
                'municipio' => 'TABASCO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            373 => 
            array (
                'id' => 45,
                'municipio' => 'TEPECHITLAN',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            374 => 
            array (
                'id' => 46,
                'municipio' => 'TEPETONGO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            375 => 
            array (
                'id' => 47,
                'municipio' => 'TEUL DE GONZALEZ ORTEGA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            376 => 
            array (
                'id' => 48,
                'municipio' => 'TLALTENANGO DE SANCHEZ ROMAN',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            377 => 
            array (
                'id' => 49,
                'municipio' => 'VALPARAISO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            378 => 
            array (
                'id' => 50,
                'municipio' => 'VETAGRANDE',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            379 => 
            array (
                'id' => 51,
                'municipio' => 'VILLA DE COS',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            380 => 
            array (
                'id' => 52,
                'municipio' => 'VILLA GARCIA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            381 => 
            array (
                'id' => 53,
                'municipio' => 'VILLA GONZALEZ ORTEGA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            382 => 
            array (
                'id' => 54,
                'municipio' => 'VILLA HIDALGO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            383 => 
            array (
                'id' => 55,
                'municipio' => 'VILLANUEVA',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            384 => 
            array (
                'id' => 56,
                'municipio' => 'ZACATECAS',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            385 => 
            array (
                'id' => 57,
                'municipio' => 'TRANCOSO',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            386 => 
            array (
                'id' => 58,
                'municipio' => 'SANTA MARIA DE LA PAZ',
                'id_estado' => 32,
                'latitud' => NULL,
                'longitud' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            387 => 
            array (
                'id' => 21,
                'municipio' => 'EMILIANO ZAPATA',
                'id_estado' => 13,
                'latitud' => '19.657542',
                'longitud' => '-98.548269',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            388 => 
            array (
                'id' => 22,
                'municipio' => 'EPAZOYUCAN',
                'id_estado' => 13,
                'latitud' => '20.017943',
                'longitud' => '-98.63609',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            389 => 
            array (
                'id' => 23,
                'municipio' => 'FRANCISCO I. MADERO',
                'id_estado' => 13,
                'latitud' => '20.245188',
                'longitud' => '-99.089315',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            390 => 
            array (
                'id' => 24,
                'municipio' => 'HUASCA DE OCAMPO',
                'id_estado' => 13,
                'latitud' => '20.203771',
                'longitud' => '-98.577575',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            391 => 
            array (
                'id' => 25,
                'municipio' => 'HUAUTLA',
                'id_estado' => 13,
                'latitud' => '21.031571',
                'longitud' => '-98.286814',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            392 => 
            array (
                'id' => 26,
                'municipio' => 'HUAZALINGO',
                'id_estado' => 13,
                'latitud' => '20.980794',
                'longitud' => '-98.507642',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            393 => 
            array (
                'id' => 27,
                'municipio' => 'HUEHUETLA',
                'id_estado' => 13,
                'latitud' => '20.459093',
                'longitud' => '-98.076451',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            394 => 
            array (
                'id' => 28,
                'municipio' => 'HUEJUTLA DE REYES',
                'id_estado' => 13,
                'latitud' => '21.152468',
                'longitud' => '-98.398142',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            395 => 
            array (
                'id' => 29,
                'municipio' => 'HUICHAPAN',
                'id_estado' => 13,
                'latitud' => '20.375274',
                'longitud' => '-99.651224',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            396 => 
            array (
                'id' => 30,
                'municipio' => 'IXMIQUILPAN',
                'id_estado' => 13,
                'latitud' => '20.484782',
                'longitud' => '-99.218845',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            397 => 
            array (
                'id' => 31,
                'municipio' => 'JACALA DE LEDEZMA',
                'id_estado' => 13,
                'latitud' => '21.0083',
                'longitud' => '-99.188516',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            398 => 
            array (
                'id' => 32,
                'municipio' => 'JALTOCAN',
                'id_estado' => 13,
                'latitud' => '21.135946',
                'longitud' => '-98.534908',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            399 => 
            array (
                'id' => 33,
                'municipio' => 'JUAREZ HIDALGO',
                'id_estado' => 13,
                'latitud' => '20.783568',
                'longitud' => '-98.828828',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            400 => 
            array (
                'id' => 34,
                'municipio' => 'LA MISION',
                'id_estado' => 13,
                'latitud' => '21.099231',
                'longitud' => '-99.122697',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            401 => 
            array (
                'id' => 35,
                'municipio' => 'LOLOTLA',
                'id_estado' => 13,
                'latitud' => '20.841212',
                'longitud' => '-98.717124',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            402 => 
            array (
                'id' => 36,
                'municipio' => 'METEPEC',
                'id_estado' => 13,
                'latitud' => '20.238581',
                'longitud' => '-98.322107',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            403 => 
            array (
                'id' => 37,
                'municipio' => 'METZTITLAN',
                'id_estado' => 13,
                'latitud' => '20.594665',
                'longitud' => '-98.764139',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            404 => 
            array (
                'id' => 38,
                'municipio' => 'MINERAL DEL CHICO',
                'id_estado' => 13,
                'latitud' => '20.215626',
                'longitud' => '-98.730138',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            405 => 
            array (
                'id' => 39,
                'municipio' => 'MINERAL DEL MONTE',
                'id_estado' => 13,
                'latitud' => '20.14046',
                'longitud' => '-98.671754',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            406 => 
            array (
                'id' => 40,
                'municipio' => 'MINERAL DE LA REFORMA',
                'id_estado' => 13,
                'latitud' => '20.07187',
                'longitud' => '-98.696739',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            407 => 
            array (
                'id' => 41,
                'municipio' => 'MIXQUIAHUALA DE JUAREZ',
                'id_estado' => 13,
                'latitud' => '20.229276',
                'longitud' => '-99.214002',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            408 => 
            array (
                'id' => 42,
                'municipio' => 'MOLANGO DE ESCAMILLA',
                'id_estado' => 13,
                'latitud' => '20.78641',
                'longitud' => '-98.729525',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            409 => 
            array (
                'id' => 43,
                'municipio' => 'NICOLAS FLORES',
                'id_estado' => 13,
                'latitud' => '20.767608',
                'longitud' => '-99.150366',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            410 => 
            array (
                'id' => 44,
                'municipio' => 'NOPALA DE VILLAGRAN',
                'id_estado' => 13,
                'latitud' => '20.251349',
                'longitud' => '-99.644521',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            411 => 
            array (
                'id' => 45,
                'municipio' => 'OMITLAN DE JUAREZ',
                'id_estado' => 13,
                'latitud' => '20.169351',
                'longitud' => '-98.64898',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            412 => 
            array (
                'id' => 46,
                'municipio' => 'PACULA',
                'id_estado' => 13,
                'latitud' => '21.050776',
                'longitud' => '-99.296267',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            413 => 
            array (
                'id' => 48,
                'municipio' => 'PISAFLORES',
                'id_estado' => 13,
                'latitud' => '21.19491',
                'longitud' => '-99.005958',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            414 => 
            array (
                'id' => 49,
                'municipio' => 'PROGRESO DE OBREGON',
                'id_estado' => 13,
                'latitud' => '20.248025',
                'longitud' => '-99.189985',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            415 => 
            array (
                'id' => 50,
                'municipio' => 'SAN AGUSTIN METZQUITITLAN',
                'id_estado' => 13,
                'latitud' => '20.532618',
                'longitud' => '-98.637858',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            416 => 
            array (
                'id' => 51,
                'municipio' => 'SAN AGUSTIN TLAXIACA',
                'id_estado' => 13,
                'latitud' => '20.115994',
                'longitud' => '-98.886686',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            417 => 
            array (
                'id' => 52,
                'municipio' => 'SAN BARTOLO TUTOTEPEC',
                'id_estado' => 13,
                'latitud' => '20.39899',
                'longitud' => '-98.201824',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            418 => 
            array (
                'id' => 53,
                'municipio' => 'SAN FELIPE ORIZATLAN',
                'id_estado' => 13,
                'latitud' => '21.170987',
                'longitud' => '-98.607805',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            419 => 
            array (
                'id' => 54,
                'municipio' => 'SAN SALVADOR',
                'id_estado' => 13,
                'latitud' => '20.284393',
                'longitud' => '-99.01559',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            420 => 
            array (
                'id' => 55,
                'municipio' => 'SANTIAGO DE ANAYA',
                'id_estado' => 13,
                'latitud' => '20.38251',
                'longitud' => '-98.963931',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            421 => 
            array (
                'id' => 56,
                'municipio' => 'SANTIAGO TULANTEPEC DE LUGO GUERRERO',
                'id_estado' => 13,
                'latitud' => '20.039287',
                'longitud' => '-98.356919',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            422 => 
            array (
                'id' => 57,
                'municipio' => 'SINGUILUCAN',
                'id_estado' => 13,
                'latitud' => '19.967398',
                'longitud' => '-98.517737',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            423 => 
            array (
                'id' => 58,
                'municipio' => 'TASQUILLO',
                'id_estado' => 13,
                'latitud' => '20.551877',
                'longitud' => '-99.312384',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            424 => 
            array (
                'id' => 59,
                'municipio' => 'TECOZAUTLA',
                'id_estado' => 13,
                'latitud' => '20.533784',
                'longitud' => '-99.634336',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            425 => 
            array (
                'id' => 60,
                'municipio' => 'TENANGO DE DORIA',
                'id_estado' => 13,
                'latitud' => '20.337999',
                'longitud' => '-98.226989',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            426 => 
            array (
                'id' => 61,
                'municipio' => 'TEPEAPULCO',
                'id_estado' => 13,
                'latitud' => '19.785649',
                'longitud' => '-98.553735',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            427 => 
            array (
                'id' => 62,
                'municipio' => 'TEPEHUACAN DE GUERRERO',
                'id_estado' => 13,
                'latitud' => '21.014134',
                'longitud' => '-98.843513',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            428 => 
            array (
                'id' => 63,
                'municipio' => 'TEPEJI DEL RIO DE OCAMPO',
                'id_estado' => 13,
                'latitud' => '19.905225',
                'longitud' => '-99.341971',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            429 => 
            array (
                'id' => 64,
                'municipio' => 'TEPETITLAN',
                'id_estado' => 13,
                'latitud' => '20.186836',
                'longitud' => '-99.380351',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            430 => 
            array (
                'id' => 65,
                'municipio' => 'TETEPANGO',
                'id_estado' => 13,
                'latitud' => '20.102714',
                'longitud' => '-99.15628',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            431 => 
            array (
                'id' => 66,
                'municipio' => 'TEZONTEPEC DE ALDAMA',
                'id_estado' => 13,
                'latitud' => '20.18404',
                'longitud' => '-99.270211',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            432 => 
            array (
                'id' => 67,
                'municipio' => 'TIANGUISTENGO',
                'id_estado' => 13,
                'latitud' => '20.728232',
                'longitud' => '-98.630827',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            433 => 
            array (
                'id' => 68,
                'municipio' => 'TIZAYUCA',
                'id_estado' => 13,
                'latitud' => '19.841031',
                'longitud' => '-98.981603',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            434 => 
            array (
                'id' => 69,
                'municipio' => 'TLAHUELILPAN',
                'id_estado' => 13,
                'latitud' => '20.13024',
                'longitud' => '-99.234832',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            435 => 
            array (
                'id' => 70,
                'municipio' => 'TLAHUILTEPA',
                'id_estado' => 13,
                'latitud' => '20.92366',
                'longitud' => '-98.949842',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            436 => 
            array (
                'id' => 71,
                'municipio' => 'TLANALAPA',
                'id_estado' => 13,
                'latitud' => '19.817886',
                'longitud' => '-98.603776',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            437 => 
            array (
                'id' => 72,
                'municipio' => 'TLANCHINOL',
                'id_estado' => 13,
                'latitud' => '20.989448',
                'longitud' => '-98.660375',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            438 => 
            array (
                'id' => 73,
                'municipio' => 'TLAXCOAPAN',
                'id_estado' => 13,
                'latitud' => '20.091459',
                'longitud' => '-99.221408',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            439 => 
            array (
                'id' => 74,
                'municipio' => 'TOLCAYUCA',
                'id_estado' => 13,
                'latitud' => '19.956573',
                'longitud' => '-98.921723',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            440 => 
            array (
                'id' => 75,
                'municipio' => 'TULA DE ALLENDE',
                'id_estado' => 13,
                'latitud' => '20.051959',
                'longitud' => '-99.332949',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            441 => 
            array (
                'id' => 76,
                'municipio' => 'TULANCINGO DE BRAVO',
                'id_estado' => 13,
                'latitud' => '20.107585',
                'longitud' => '-98.382162',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            442 => 
            array (
                'id' => 77,
                'municipio' => 'VILLA DE TEZONTEPEC',
                'id_estado' => 13,
                'latitud' => '19.879811',
                'longitud' => '-98.81929',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            443 => 
            array (
                'id' => 78,
                'municipio' => 'XOCHIATIPAN',
                'id_estado' => 13,
                'latitud' => '20.835249',
                'longitud' => '-98.28468',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            444 => 
            array (
                'id' => 79,
                'municipio' => 'XOCHICOATLAN',
                'id_estado' => 13,
                'latitud' => '20.777181',
                'longitud' => '-98.678636',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            445 => 
            array (
                'id' => 80,
                'municipio' => 'YAHUALICA',
                'id_estado' => 13,
                'latitud' => '20.952656',
                'longitud' => '-98.381917',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            446 => 
            array (
                'id' => 81,
                'municipio' => 'ZACUALTIPAN DE ANGELES',
                'id_estado' => 13,
                'latitud' => '20.645227',
                'longitud' => '-98.653554',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            447 => 
            array (
                'id' => 82,
                'municipio' => 'ZAPOTLAN DE JUAREZ',
                'id_estado' => 13,
                'latitud' => '19.974041',
                'longitud' => '-98.861885',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            448 => 
            array (
                'id' => 83,
                'municipio' => 'ZEMPOALA',
                'id_estado' => 13,
                'latitud' => '19.915315',
                'longitud' => '-98.668686',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            449 => 
            array (
                'id' => 84,
                'municipio' => 'ZIMAPAN',
                'id_estado' => 13,
                'latitud' => '20.738087',
                'longitud' => '-99.383155',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}