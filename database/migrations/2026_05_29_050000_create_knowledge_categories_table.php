<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('knowledge_categories')) {
            return;
        }

        Schema::create('knowledge_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->uuid('proyecto_id')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('proyecto_id')->references('id')->on('projects')->nullOnDelete();
            $table->index('proyecto_id');
            $table->index('activo');
        });

        Schema::table('knowledge_categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('knowledge_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_categories');
    }
};
