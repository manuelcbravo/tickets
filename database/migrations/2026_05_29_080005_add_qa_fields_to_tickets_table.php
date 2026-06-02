<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('tickets', 'qa_status')) {
                $table->string('qa_status')->nullable()->after('has_code_changes')->index();
            }

            if (! Schema::hasColumn('tickets', 'qa_approved_at')) {
                $table->timestamp('qa_approved_at')->nullable()->after('qa_status');
            }

            if (! Schema::hasColumn('tickets', 'qa_approved_by_id')) {
                $table->foreignId('qa_approved_by_id')->nullable()->after('qa_approved_at')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('tickets', 'validated_at')) {
                $table->timestamp('validated_at')->nullable()->after('qa_approved_by_id');
            }

            if (! Schema::hasColumn('tickets', 'validated_by_id')) {
                $table->foreignId('validated_by_id')->nullable()->after('validated_at')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('tickets', 'reopen_count')) {
                $table->unsignedInteger('reopen_count')->default(0)->after('validated_by_id')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'validated_by_id')) {
                $table->dropForeign(['validated_by_id']);
            }

            if (Schema::hasColumn('tickets', 'qa_approved_by_id')) {
                $table->dropForeign(['qa_approved_by_id']);
            }

            foreach (['reopen_count', 'validated_by_id', 'validated_at', 'qa_approved_by_id', 'qa_approved_at', 'qa_status'] as $column) {
                if (Schema::hasColumn('tickets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
