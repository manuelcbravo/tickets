<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('tickets', 'priority_score')) {
                $table->unsignedSmallInteger('priority_score')->nullable()->after('prioridad_id');
            }

            if (! Schema::hasColumn('tickets', 'triage_notes')) {
                $table->text('triage_notes')->nullable()->after('priority_score');
            }

            if (! Schema::hasColumn('tickets', 'missing_information')) {
                $table->jsonb('missing_information')->nullable()->after('triage_notes');
            }

            if (! Schema::hasColumn('tickets', 'triage_completed_at')) {
                $table->timestamp('triage_completed_at')->nullable()->after('missing_information');
            }

            if (! Schema::hasColumn('tickets', 'triage_by_id')) {
                $table->foreignId('triage_by_id')->nullable()->after('triage_completed_at')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('tickets', 'prioritized_at')) {
                $table->timestamp('prioritized_at')->nullable()->after('triage_by_id');
            }

            if (! Schema::hasColumn('tickets', 'prioritized_by_id')) {
                $table->foreignId('prioritized_by_id')->nullable()->after('prioritized_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            foreach (['triage_by_id', 'prioritized_by_id'] as $column) {
                if (Schema::hasColumn('tickets', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }

            foreach (['priority_score', 'triage_notes', 'missing_information', 'triage_completed_at', 'prioritized_at'] as $column) {
                if (Schema::hasColumn('tickets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
