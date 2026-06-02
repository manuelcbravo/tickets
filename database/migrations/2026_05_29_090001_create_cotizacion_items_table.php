<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cotizacion_items')) {
            return;
        }

        Schema::create('cotizacion_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cotizacion_id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('tipo', 40)->default('servicio')->index();
            $table->decimal('cantidad', 12, 2)->default(1);
            $table->string('unidad', 50)->default('servicio');
            $table->decimal('precio_unitario', 14, 2)->default(0);
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->unsignedInteger('horas_estimadas')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('es_opcional')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->cascadeOnDelete();
            $table->index(['cotizacion_id', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_items');
    }
};
