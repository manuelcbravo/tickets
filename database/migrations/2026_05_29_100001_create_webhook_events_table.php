<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('webhook_events')) {
            return;
        }

        Schema::create('webhook_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('integration_id')->nullable();
            $table->string('provider', 40)->index();
            $table->string('event_type', 120)->nullable()->index();
            $table->string('external_id')->nullable();
            $table->string('related_type')->nullable();
            $table->uuid('related_id')->nullable();
            $table->uuid('ticket_id')->nullable()->index();
            $table->jsonb('payload')->nullable();
            $table->jsonb('headers')->nullable();
            $table->string('status', 40)->default('received')->index();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->foreign('integration_id')->references('id')->on('integraciones')->nullOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->nullOnDelete();
            $table->unique(['provider', 'external_id', 'event_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_events');
    }
};
