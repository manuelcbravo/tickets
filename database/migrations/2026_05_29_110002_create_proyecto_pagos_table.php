<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_pagos')) {
            return;
        }

        Schema::create('proyecto_pagos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('folio')->unique();
            $table->uuid('cliente_id');
            $table->uuid('proyecto_id')->nullable();
            $table->date('fecha_pago');
            $table->string('moneda', 3)->default('MXN');
            $table->decimal('monto', 14, 2);
            $table->string('metodo_pago', 40)->nullable();
            $table->string('referencia')->nullable();
            $table->string('banco')->nullable();
            $table->string('cuenta_origen')->nullable();
            $table->text('notas')->nullable();
            $table->string('estado', 40)->default('registrado');
            $table->foreignId('registrado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('confirmado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmado_at')->nullable();
            $table->foreignId('cancelado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('cancelado_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->foreign('proyecto_id')->references('id')->on('projects')->nullOnDelete();
            $table->index(['cliente_id', 'estado']);
            $table->index(['proyecto_id', 'estado']);
            $table->index('fecha_pago');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_pagos');
    }
};
