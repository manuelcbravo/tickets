<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cotizaciones')) {
            return;
        }

        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('uuid')->nullable()->unique();
            $table->string('folio')->unique();
            $table->uuid('cliente_id');
            $table->uuid('proyecto_id')->nullable();
            $table->uuid('ticket_origen_id')->nullable();
            $table->uuid('contacto_id')->nullable();
            $table->foreignId('creado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('aprobado_internamente_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('aprobado_cliente_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('alcance')->nullable();
            $table->text('exclusiones')->nullable();
            $table->text('entregables')->nullable();
            $table->text('condiciones')->nullable();
            $table->text('notas_internas')->nullable();
            $table->string('moneda', 3)->default('MXN');
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('descuento', 14, 2)->default(0);
            $table->decimal('impuesto', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->unsignedInteger('horas_estimadas')->nullable();
            $table->unsignedInteger('dias_estimados')->nullable();
            $table->date('fecha_estimada_inicio')->nullable();
            $table->date('fecha_estimada_entrega')->nullable();
            $table->string('estado', 40)->default('borrador')->index();
            $table->timestamp('enviada_at')->nullable();
            $table->timestamp('aprobada_internamente_at')->nullable();
            $table->timestamp('aprobada_cliente_at')->nullable();
            $table->timestamp('rechazada_at')->nullable();
            $table->timestamp('cancelada_at')->nullable();
            $table->timestamp('convertida_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('clients')->restrictOnDelete();
            $table->foreign('proyecto_id')->references('id')->on('projects')->nullOnDelete();
            $table->foreign('ticket_origen_id')->references('id')->on('tickets')->nullOnDelete();
            $table->foreign('contacto_id')->references('id')->on('client_contacts')->nullOnDelete();

            $table->index(['cliente_id', 'estado']);
            $table->index('proyecto_id');
            $table->index('ticket_origen_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
