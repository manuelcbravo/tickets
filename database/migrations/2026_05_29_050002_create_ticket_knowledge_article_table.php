<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_knowledge_article')) {
            return;
        }

        Schema::create('ticket_knowledge_article', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->uuid('knowledge_article_id');
            $table->string('tipo_relacion')->default('relacionado');
            $table->text('notas')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('knowledge_article_id')->references('id')->on('knowledge_articles')->cascadeOnDelete();
            $table->unique(['ticket_id', 'knowledge_article_id', 'tipo_relacion'], 'ticket_knowledge_article_unique');
            $table->index('knowledge_article_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_knowledge_article');
    }
};
