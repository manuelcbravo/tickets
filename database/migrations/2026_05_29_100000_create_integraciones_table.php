<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('integraciones')) {
            return;
        }

        Schema::create('integraciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->string('tipo', 40)->index();
            $table->string('proveedor', 40)->nullable()->index();
            $table->text('descripcion')->nullable();
            $table->jsonb('config')->nullable();
            $table->boolean('activo')->default(true)->index();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tipo', 'proveedor', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integraciones');
    }
};
