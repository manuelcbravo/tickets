<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('nombre', 180)->nullable()->after('company_id')->index();
            $table->string('razon_social', 180)->nullable()->after('nombre');
            $table->string('sitio_web')->nullable()->after('phone');
            $table->string('estatus', 30)->default('activo')->after('is_blacklisted')->index();
            $table->string('clasificacion', 40)->nullable()->after('estatus');
            $table->text('notas_internas')->nullable()->after('clasificacion');

            $table->index('razon_social');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['nombre']);
            $table->dropIndex(['razon_social']);
            $table->dropIndex(['estatus']);
            $table->dropColumn([
                'nombre',
                'razon_social',
                'sitio_web',
                'estatus',
                'clasificacion',
                'notas_internas',
            ]);
        });
    }
};
