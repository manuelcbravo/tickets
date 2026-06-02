<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('tickets', 'development_status')) {
                $table->string('development_status')->nullable()->after('resolution')->index();
            }

            if (! Schema::hasColumn('tickets', 'has_code_changes')) {
                $table->boolean('has_code_changes')->default(false)->after('development_status')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'has_code_changes')) {
                $table->dropColumn('has_code_changes');
            }

            if (Schema::hasColumn('tickets', 'development_status')) {
                $table->dropColumn('development_status');
            }
        });
    }
};
