<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement('DROP INDEX IF EXISTS audits_auditable_type_auditable_id_index');

        DB::statement('ALTER TABLE audits ALTER COLUMN auditable_id TYPE varchar(36) USING auditable_id::varchar');

        DB::statement('CREATE INDEX audits_auditable_type_auditable_id_index ON audits (auditable_type, auditable_id)');
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement('DROP INDEX IF EXISTS audits_auditable_type_auditable_id_index');

        DB::statement('ALTER TABLE audits ALTER COLUMN auditable_id TYPE bigint USING auditable_id::bigint');

        DB::statement('CREATE INDEX audits_auditable_type_auditable_id_index ON audits (auditable_type, auditable_id)');
    }
};
