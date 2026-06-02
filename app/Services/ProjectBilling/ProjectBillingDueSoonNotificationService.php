<?php

namespace App\Services\ProjectBilling;

use App\Mail\ProjectBilling\ProjectChargesDueSoonMail;
use App\Models\NotificationLog;
use App\Models\ProyectoCargo;
use App\Models\User;
use App\Services\Notifications\InternalNotificationService;
use App\Services\Notifications\NotificationLogService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProjectBillingDueSoonNotificationService
{
    public function __construct(
        private readonly InternalNotificationService $internalNotifications,
        private readonly NotificationLogService $logs,
    ) {}

    public function check(): array
    {
        $days = (int) config('notifications.project_billing_due_soon_days', 3);
        $reviewDate = now()->toDateString();
        $actionUrl = route('project-billing.charges.index', ['por_vencer' => 1]);
        $admins = $this->superAdmins();
        $alreadyNotifiedChargeIds = $this->alreadyNotifiedChargeIds($reviewDate);
        $charges = $this->dueSoonCharges($days)
            ->reject(fn (ProyectoCargo $charge): bool => in_array($charge->id, $alreadyNotifiedChargeIds, true))
            ->values();

        if ($charges->isEmpty() || $admins->isEmpty()) {
            return [
                'charges' => $charges->count(),
                'admins' => $admins->count(),
                'emails_sent' => 0,
                'emails_failed' => 0,
                'internal_notifications' => 0,
            ];
        }

        $internalCount = 0;
        $sent = 0;
        $failed = 0;

        foreach ($admins as $admin) {
            if ($this->internalNotifications->notifyProjectChargesDueSoon($admin, $charges->count(), $actionUrl, $reviewDate)) {
                $internalCount++;
            }

            $log = $this->logs->create([
                'user_id' => $admin->id,
                'channel' => 'email',
                'direction' => 'outbound',
                'recipient' => $admin->email,
                'subject' => 'Pagos de proyectos proximos a vencer',
                'message' => 'Resumen de cargos de proyectos proximos a vencer.',
                'payload' => [
                    'event' => 'project_charge_due_soon',
                    'review_date' => $reviewDate,
                    'days' => $days,
                    'charge_ids' => $charges->pluck('id')->values()->all(),
                ],
                'status' => 'pending',
            ]);

            if (! config('integrations.email.enabled')) {
                $this->logs->markFailed($log, 'El envio de correo esta desactivado en configuracion.');
                $failed++;

                continue;
            }

            try {
                Mail::to($admin->email)->send(new ProjectChargesDueSoonMail($charges, now()->addDays($days)->toDateString(), $days, $actionUrl));
                $this->logs->markSent($log);
                $sent++;
            } catch (\Throwable $exception) {
                Log::error('No se pudo enviar el correo de pagos proximos a vencer.', [
                    'user_id' => $admin->id,
                    'error' => $exception->getMessage(),
                ]);

                $this->logs->markFailed($log, $exception->getMessage());
                $failed++;
            }
        }

        return [
            'charges' => $charges->count(),
            'admins' => $admins->count(),
            'emails_sent' => $sent,
            'emails_failed' => $failed,
            'internal_notifications' => $internalCount,
        ];
    }

    private function dueSoonCharges(int $days): Collection
    {
        return ProyectoCargo::query()
            ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre'])
            ->whereNotIn('estado', ['pagado', 'cancelado', 'condonado'])
            ->where('saldo', '>', 0)
            ->whereBetween('fecha_vencimiento', [now()->toDateString(), now()->addDays($days)->toDateString()])
            ->orderBy('fecha_vencimiento')
            ->get();
    }

    private function superAdmins(): Collection
    {
        $configuredNames = collect(config('notifications.super_admin_role_names', []))
            ->filter()
            ->map(fn (string $name): string => mb_strtolower($name))
            ->unique();

        $roleNames = Role::query()
            ->get(['name'])
            ->filter(fn (Role $role): bool => $configuredNames->contains(mb_strtolower($role->name)))
            ->pluck('name')
            ->values()
            ->all();

        if ($roleNames !== []) {
            return User::role($roleNames)->get();
        }

        if (! Permission::query()->where('name', 'notifications.manage')->exists()) {
            return collect();
        }

        return User::permission('notifications.manage')->get();
    }

    private function alreadyNotifiedChargeIds(string $reviewDate): array
    {
        return NotificationLog::query()
            ->where('channel', 'email')
            ->where('subject', 'Pagos de proyectos proximos a vencer')
            ->whereDate('created_at', $reviewDate)
            ->whereIn('status', ['pending', 'queued', 'sent'])
            ->get()
            ->flatMap(fn (NotificationLog $log): array => data_get($log->payload, 'charge_ids', []))
            ->unique()
            ->values()
            ->all();
    }
}
