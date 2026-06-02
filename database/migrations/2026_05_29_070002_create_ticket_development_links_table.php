<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_development_links')) {
            return;
        }

        Schema::create('ticket_development_links', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->uuid('development_task_id')->nullable();
            $table->string('tipo');
            $table->string('titulo')->nullable();
            $table->string('url')->nullable();
            $table->string('referencia')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('development_task_id')->references('id')->on('ticket_development_tasks')->nullOnDelete();
            $table->unique(['ticket_id', 'tipo', 'url']);
            $table->index(['ticket_id', 'tipo']);
            $table->index('development_task_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_development_links');
    }
};
