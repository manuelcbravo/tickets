<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cotizacion_aprobaciones')) {
            return;
        }

        Schema::create('cotizacion_aprobaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cotizacion_id');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tipo', 30);
            $table->string('estado', 30)->default('pendiente');
            $table->text('comentario')->nullable();
            $table->string('nombre_aprobador')->nullable();
            $table->string('email_aprobador')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->cascadeOnDelete();
            $table->index(['cotizacion_id', 'tipo', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_aprobaciones');
    }
};
