<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('knowledge_articles')) {
            return;
        }

        Schema::create('knowledge_articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_id')->nullable();
            $table->uuid('cliente_id')->nullable();
            $table->uuid('proyecto_id')->nullable();
            $table->uuid('proyecto_modulo_id')->nullable();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('resumen')->nullable();
            $table->longText('contenido');
            $table->string('tipo')->default('procedimiento');
            $table->string('visibilidad')->default('interna');
            $table->string('estatus')->default('borrador');
            $table->integer('prioridad')->default(0);
            $table->jsonb('tags')->nullable();
            $table->uuid('fuente_ticket_id')->nullable();
            $table->foreignId('creado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('actualizado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('revisado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('publicado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('knowledge_categories')->nullOnDelete();
            $table->foreign('cliente_id')->references('id')->on('clients')->nullOnDelete();
            $table->foreign('proyecto_id')->references('id')->on('projects')->nullOnDelete();
            $table->foreign('proyecto_modulo_id')->references('id')->on('project_modules')->nullOnDelete();
            $table->foreign('fuente_ticket_id')->references('id')->on('tickets')->nullOnDelete();

            $table->index('category_id');
            $table->index('cliente_id');
            $table->index('proyecto_id');
            $table->index('proyecto_modulo_id');
            $table->index('fuente_ticket_id');
            $table->index('tipo');
            $table->index('visibilidad');
            $table->index('estatus');
            $table->index('prioridad');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_articles');
    }
};
