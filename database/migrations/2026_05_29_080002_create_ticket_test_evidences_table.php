<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_test_evidences')) {
            return;
        }

        Schema::create('ticket_test_evidences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->uuid('test_result_id')->nullable();
            $table->uuid('adjunto_id')->nullable();
            $table->foreignId('uploaded_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('tipo')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('test_result_id')->references('id')->on('ticket_test_results')->nullOnDelete();
            $table->foreign('adjunto_id')->references('id')->on('ticket_attachments')->nullOnDelete();
            $table->index(['ticket_id', 'tipo']);
            $table->index('test_result_id');
            $table->index('adjunto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_test_evidences');
    }
};
