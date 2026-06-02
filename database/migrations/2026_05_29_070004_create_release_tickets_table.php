<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('release_tickets')) {
            return;
        }

        Schema::create('release_tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('release_id');
            $table->uuid('ticket_id');
            $table->uuid('development_task_id')->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('release_id')->references('id')->on('releases')->cascadeOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('development_task_id')->references('id')->on('ticket_development_tasks')->nullOnDelete();
            $table->unique(['release_id', 'ticket_id']);
            $table->index('ticket_id');
            $table->index('development_task_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('release_tickets');
    }
};
