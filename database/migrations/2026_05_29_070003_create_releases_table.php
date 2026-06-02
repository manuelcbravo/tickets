<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('releases')) {
            return;
        }

        Schema::create('releases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proyecto_id');
            $table->uuid('ambiente_id')->nullable();
            $table->string('nombre');
            $table->string('version')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('borrador');
            $table->text('release_notes')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('released_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('proyecto_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('ambiente_id')->references('id')->on('environments')->nullOnDelete();
            $table->index(['proyecto_id', 'estado']);
            $table->index('ambiente_id');
            $table->index('scheduled_at');
            $table->index('released_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('releases');
    }
};
