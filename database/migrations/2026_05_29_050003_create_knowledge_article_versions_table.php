<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('knowledge_article_versions')) {
            return;
        }

        Schema::create('knowledge_article_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('knowledge_article_id');
            $table->unsignedInteger('version');
            $table->string('titulo');
            $table->text('resumen')->nullable();
            $table->longText('contenido');
            $table->string('estatus')->nullable();
            $table->string('visibilidad')->nullable();
            $table->foreignId('changed_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('change_summary')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('knowledge_article_id')->references('id')->on('knowledge_articles')->cascadeOnDelete();
            $table->unique(['knowledge_article_id', 'version'], 'knowledge_article_version_unique');
            $table->index('changed_by_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_article_versions');
    }
};
