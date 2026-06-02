<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_planes_cobro')) {
            return;
        }

        Schema::create('proyecto_planes_cobro', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proyecto_id');
            $table->uuid('cliente_id');
            $table->string('tipo_cobro', 40);
            $table->string('moneda', 3)->default('MXN');
            $table->decimal('monto_total', 14, 2)->nullable();
            $table->decimal('monto_mensual', 14, 2)->nullable();
            $table->unsignedTinyInteger('dia_vencimiento')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('periodicidad', 40)->nullable();
            $table->boolean('activo')->default(true);
            $table->string('estado', 40)->default('activo');
            $table->text('notas')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('proyecto_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('cliente_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->index(['proyecto_id', 'activo']);
            $table->index(['cliente_id', 'estado']);
            $table->index('tipo_cobro');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_planes_cobro');
    }
};
