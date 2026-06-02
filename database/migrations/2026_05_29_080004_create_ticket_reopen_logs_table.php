<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_reopen_logs')) {
            return;
        }

        Schema::create('ticket_reopen_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->foreignId('reopened_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('previous_closed_at')->nullable();
            $table->text('reason');
            $table->string('root_cause')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->index(['ticket_id', 'created_at']);
            $table->index('root_cause');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_reopen_logs');
    }
};
