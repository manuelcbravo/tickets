<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('tickets', 'quote_status')) {
                $table->string('quote_status', 40)->nullable()->after('requires_quote')->index();
            }

            if (! Schema::hasColumn('tickets', 'quote_id')) {
                $table->uuid('quote_id')->nullable()->after('quote_status')->index();
                $table->foreign('quote_id')->references('id')->on('cotizaciones')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'quote_id')) {
                $table->dropForeign(['quote_id']);
                $table->dropColumn('quote_id');
            }

            if (Schema::hasColumn('tickets', 'quote_status')) {
                $table->dropColumn('quote_status');
            }
        });
    }
};
