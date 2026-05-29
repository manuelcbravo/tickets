<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_relacion')->index();
            $table->string('tabla_relacion')->index();
            $table->string('titulo');
            $table->text('seguimiento');
            $table->foreignId('tipo_id')->constrained('cat_seguimiento_tipos');

            $table->string('estado')->nullable()->index();
            $table->string('prioridad')->nullable()->index();
            $table->date('fecha_seguimiento')->nullable()->index();
            $table->date('fecha_proxima_accion')->nullable();
            $table->string('resultado')->nullable();
            $table->string('observaciones')->nullable();

            $table->foreignId('created_by_user_id')->constrained('users');
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['tabla_relacion', 'id_relacion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimientos');
    }
};
