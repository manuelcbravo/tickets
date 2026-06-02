<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('repositorios')) {
            return;
        }

        Schema::create('repositorios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proyecto_id');
            $table->string('nombre');
            $table->string('proveedor')->nullable();
            $table->string('url');
            $table->string('rama_principal')->default('main');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('proyecto_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->unique(['proyecto_id', 'url']);
            $table->index(['proyecto_id', 'activo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repositorios');
    }
};
