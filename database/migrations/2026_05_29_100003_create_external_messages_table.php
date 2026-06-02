<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('external_messages')) {
            return;
        }

        Schema::create('external_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('integration_id')->nullable();
            $table->uuid('ticket_id')->nullable()->index();
            $table->uuid('cliente_id')->nullable()->index();
            $table->uuid('contacto_id')->nullable()->index();
            $table->string('channel', 40)->index();
            $table->string('external_id')->nullable();
            $table->string('sender')->nullable();
            $table->string('recipient')->nullable();
            $table->text('message')->nullable();
            $table->jsonb('attachments')->nullable();
            $table->jsonb('payload')->nullable();
            $table->string('direction', 20)->index();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('integration_id')->references('id')->on('integraciones')->nullOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->nullOnDelete();
            $table->foreign('cliente_id')->references('id')->on('clients')->nullOnDelete();
            $table->foreign('contacto_id')->references('id')->on('client_contacts')->nullOnDelete();
            $table->unique(['channel', 'external_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_messages');
    }
};
