<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_relaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->uuid('related_ticket_id');
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('related_ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->unique(['ticket_id', 'related_ticket_id', 'tipo']);
            $table->index(['ticket_id', 'tipo']);
            $table->index('related_ticket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_relaciones');
    }
};
