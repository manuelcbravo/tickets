<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RolePermissionSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CatUsoCfdisTableSeeder::class);
        $this->call(CatRegimenFiscalesTableSeeder::class);
        $this->call(CatSeguimientoTiposTableSeeder::class);
        $this->call(CatFormaPagoSatsTableSeeder::class);
        $this->call(CatClienteTiposTableSeeder::class);
        $this->call(CatEstadosTableSeeder::class);
        $this->call(CatMunicipiosTableSeeder::class);
        $this->call(CatSatServiciosTableSeeder::class);
        $this->call(CatSatClaveUnidadesTableSeeder::class);

    }
}
