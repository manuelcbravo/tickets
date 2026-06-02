<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->string('nombre', 180);
            $table->text('descripcion')->nullable();
            $table->string('url_produccion')->nullable();
            $table->string('url_staging')->nullable();
            $table->string('repositorio_url')->nullable();
            $table->string('documentacion_url')->nullable();
            $table->string('tecnologia')->nullable();
            $table->foreignId('responsable_tecnico_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('estado', 40)->default('mantenimiento');
            $table->string('criticidad', 30)->default('media');
            $table->text('notas_internas')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->index('client_id');
            $table->index('nombre');
            $table->index('estado');
            $table->index('criticidad');
            $table->index('responsable_tecnico_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
