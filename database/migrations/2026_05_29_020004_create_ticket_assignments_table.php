<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('asignado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('rol_en_ticket')->default('responsable');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->index(['ticket_id', 'activo']);
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_assignments');
    }
};
