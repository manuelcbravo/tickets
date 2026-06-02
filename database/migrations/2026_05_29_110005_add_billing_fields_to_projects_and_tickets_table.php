<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (! Schema::hasColumn('projects', 'billing_status')) {
                $table->string('billing_status')->nullable()->after('estado');
            }
            if (! Schema::hasColumn('projects', 'saldo_pendiente')) {
                $table->decimal('saldo_pendiente', 14, 2)->default(0)->after('billing_status');
            }
            if (! Schema::hasColumn('projects', 'saldo_vencido')) {
                $table->decimal('saldo_vencido', 14, 2)->default(0)->after('saldo_pendiente');
            }
            if (! Schema::hasColumn('projects', 'ultimo_pago_at')) {
                $table->timestamp('ultimo_pago_at')->nullable()->after('saldo_vencido');
            }
            if (! Schema::hasColumn('projects', 'proximo_vencimiento_at')) {
                $table->timestamp('proximo_vencimiento_at')->nullable()->after('ultimo_pago_at');
            }
        });

        Schema::table('tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('tickets', 'billing_warning_acknowledged_at')) {
                $table->timestamp('billing_warning_acknowledged_at')->nullable()->after('external_reference');
            }
            if (! Schema::hasColumn('tickets', 'billing_warning_acknowledged_by_id')) {
                $table->foreignId('billing_warning_acknowledged_by_id')->nullable()->after('billing_warning_acknowledged_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'billing_warning_acknowledged_by_id')) {
                $table->dropConstrainedForeignId('billing_warning_acknowledged_by_id');
            }
            if (Schema::hasColumn('tickets', 'billing_warning_acknowledged_at')) {
                $table->dropColumn('billing_warning_acknowledged_at');
            }
        });

        Schema::table('projects', function (Blueprint $table) {
            foreach (['proximo_vencimiento_at', 'ultimo_pago_at', 'saldo_vencido', 'saldo_pendiente', 'billing_status'] as $column) {
                if (Schema::hasColumn('projects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
