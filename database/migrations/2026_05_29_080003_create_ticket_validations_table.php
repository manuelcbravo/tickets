<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_validations')) {
            return;
        }

        Schema::create('ticket_validations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->foreignId('validated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tipo')->default('interna');
            $table->string('status')->default('pendiente');
            $table->text('comentario')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->index(['ticket_id', 'status']);
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_validations');
    }
};
