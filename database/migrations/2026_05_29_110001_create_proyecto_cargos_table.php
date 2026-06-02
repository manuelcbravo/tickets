<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_cargos')) {
            return;
        }

        Schema::create('proyecto_cargos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('folio')->unique();
            $table->uuid('cliente_id');
            $table->uuid('proyecto_id');
            $table->uuid('plan_cobro_id')->nullable();
            $table->uuid('cotizacion_id')->nullable();
            $table->string('concepto');
            $table->text('descripcion')->nullable();
            $table->date('periodo_inicio')->nullable();
            $table->date('periodo_fin')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->string('moneda', 3)->default('MXN');
            $table->decimal('monto', 14, 2)->default(0);
            $table->decimal('monto_pagado', 14, 2)->default(0);
            $table->decimal('saldo', 14, 2)->default(0);
            $table->string('estado', 40)->default('pendiente');
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('cancelled_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->foreign('proyecto_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('plan_cobro_id')->references('id')->on('proyecto_planes_cobro')->nullOnDelete();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->nullOnDelete();
            $table->unique(['proyecto_id', 'periodo_inicio', 'periodo_fin', 'concepto'], 'proyecto_cargos_periodo_unique');
            $table->index(['proyecto_id', 'estado']);
            $table->index(['cliente_id', 'estado']);
            $table->index('fecha_vencimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_cargos');
    }
};
