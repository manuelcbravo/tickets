<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_pago_documentos')) {
            return;
        }

        Schema::create('proyecto_pago_documentos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pago_id');
            $table->foreignId('uploaded_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nombre_original');
            $table->string('ruta');
            $table->string('disk')->default('public');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pago_id')->references('id')->on('proyecto_pagos')->cascadeOnDelete();
            $table->index('pago_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_pago_documentos');
    }
};
