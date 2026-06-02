<?php

namespace App\Console\Commands;

use App\Services\ProjectBilling\ProjectBillingDueSoonNotificationService;
use Illuminate\Console\Command;

class CheckProjectPaymentsDueNotificationsCommand extends Command
{
    protected $signature = 'notifications:check-project-payments-due';

    protected $description = 'Revisa cargos de proyectos proximos a vencer y notifica a super administradores.';

    public function handle(ProjectBillingDueSoonNotificationService $service): int
    {
        $result = $service->check();

        if ($result['charges'] === 0) {
            $this->info('No hay cargos proximos a vencer pendientes de notificar.');

            return self::SUCCESS;
        }

        if ($result['admins'] === 0) {
            $this->warn('No se encontraron super administradores para notificar.');

            return self::SUCCESS;
        }

        $this->info("Cargos incluidos: {$result['charges']}");
        $this->info("Super administradores: {$result['admins']}");
        $this->info("Correos enviados: {$result['emails_sent']}");
        $this->info("Correos fallidos: {$result['emails_failed']}");
        $this->info("Notificaciones internas: {$result['internal_notifications']}");

        return self::SUCCESS;
    }
}
