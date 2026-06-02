<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (! Schema::hasColumn('projects', 'objetivo')) {
                $table->text('objetivo')->nullable();
            }
            if (! Schema::hasColumn('projects', 'alcance')) {
                $table->text('alcance')->nullable();
            }
            if (! Schema::hasColumn('projects', 'descripcion_funcional')) {
                $table->text('descripcion_funcional')->nullable();
            }
            if (! Schema::hasColumn('projects', 'descripcion_tecnica')) {
                $table->text('descripcion_tecnica')->nullable();
            }
            if (! Schema::hasColumn('projects', 'restricciones')) {
                $table->text('restricciones')->nullable();
            }
            if (! Schema::hasColumn('projects', 'notas_planeacion')) {
                $table->text('notas_planeacion')->nullable();
            }
            if (! Schema::hasColumn('projects', 'fecha_inicio')) {
                $table->date('fecha_inicio')->nullable();
            }
            if (! Schema::hasColumn('projects', 'fecha_objetivo')) {
                $table->date('fecha_objetivo')->nullable();
            }
            if (! Schema::hasColumn('projects', 'estado_planeacion')) {
                $table->string('estado_planeacion', 40)->nullable()->index();
            }
            if (! Schema::hasColumn('projects', 'responsable_planeacion_id')) {
                $table->foreignId('responsable_planeacion_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('projects', 'prioridad_planeacion')) {
                $table->string('prioridad_planeacion', 30)->nullable()->index();
            }
            if (! Schema::hasColumn('projects', 'avance_porcentaje')) {
                $table->unsignedTinyInteger('avance_porcentaje')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'responsable_planeacion_id')) {
                $table->dropConstrainedForeignId('responsable_planeacion_id');
            }

            foreach ([
                'objetivo',
                'alcance',
                'descripcion_funcional',
                'descripcion_tecnica',
                'restricciones',
                'notas_planeacion',
                'fecha_inicio',
                'fecha_objetivo',
                'estado_planeacion',
                'prioridad_planeacion',
                'avance_porcentaje',
            ] as $column) {
                if (Schema::hasColumn('projects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
