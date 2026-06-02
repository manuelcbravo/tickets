<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('notification_logs')) {
            return;
        }

        Schema::create('notification_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('integration_id')->nullable();
            $table->uuid('ticket_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->uuid('cliente_id')->nullable()->index();
            $table->uuid('contacto_id')->nullable()->index();
            $table->string('channel', 40)->index();
            $table->string('direction', 20)->default('outbound')->index();
            $table->string('recipient')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->jsonb('payload')->nullable();
            $table->string('status', 40)->default('pending')->index();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->foreign('integration_id')->references('id')->on('integraciones')->nullOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->nullOnDelete();
            $table->foreign('cliente_id')->references('id')->on('clients')->nullOnDelete();
            $table->foreign('contacto_id')->references('id')->on('client_contacts')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
