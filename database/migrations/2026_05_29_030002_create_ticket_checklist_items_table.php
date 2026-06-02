<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_checklist_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('tipo')->nullable();
            $table->boolean('requerido')->default(false);
            $table->boolean('completado')->default(false);
            $table->foreignId('completado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completado_at')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->index(['ticket_id', 'orden']);
            $table->index(['ticket_id', 'completado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_checklist_items');
    }
};
