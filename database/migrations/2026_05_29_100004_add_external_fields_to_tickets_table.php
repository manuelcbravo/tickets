<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('tickets', 'external_source')) {
                $table->string('external_source')->nullable()->after('quote_id')->index();
            }

            if (! Schema::hasColumn('tickets', 'external_reference')) {
                $table->string('external_reference')->nullable()->after('external_source')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'external_reference')) {
                $table->dropColumn('external_reference');
            }

            if (Schema::hasColumn('tickets', 'external_source')) {
                $table->dropColumn('external_source');
            }
        });
    }
};
