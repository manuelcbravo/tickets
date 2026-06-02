<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_pago_aplicaciones')) {
            return;
        }

        Schema::create('proyecto_pago_aplicaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pago_id');
            $table->uuid('cargo_id');
            $table->decimal('monto_aplicado', 14, 2);
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('pago_id')->references('id')->on('proyecto_pagos')->cascadeOnDelete();
            $table->foreign('cargo_id')->references('id')->on('proyecto_cargos')->cascadeOnDelete();
            $table->unique(['pago_id', 'cargo_id']);
            $table->index('cargo_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_pago_aplicaciones');
    }
};
