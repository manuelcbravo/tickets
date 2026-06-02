<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->string('nombre', 180);
            $table->string('email')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('puesto', 120)->nullable();
            $table->string('tipo_contacto', 40)->default('solicitante');
            $table->boolean('es_principal')->default(false);
            $table->boolean('recibe_notificaciones')->default(true);
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->index(['client_id', 'es_principal']);
            $table->index('tipo_contacto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};
