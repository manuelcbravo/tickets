<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('test_cases')) {
            return;
        }

        Schema::create('test_cases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id')->nullable();
            $table->uuid('proyecto_id')->nullable();
            $table->uuid('proyecto_modulo_id')->nullable();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('pasos')->nullable();
            $table->text('resultado_esperado')->nullable();
            $table->string('tipo')->default('manual');
            $table->string('prioridad')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('proyecto_id')->references('id')->on('projects')->nullOnDelete();
            $table->foreign('proyecto_modulo_id')->references('id')->on('project_modules')->nullOnDelete();
            $table->index(['ticket_id', 'activo']);
            $table->index(['proyecto_id', 'proyecto_modulo_id']);
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_cases');
    }
};
