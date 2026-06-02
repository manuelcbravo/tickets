<?php

namespace App\Services\QA;

use App\Models\TestCase;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;

class TestCaseService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function create(Ticket $ticket, array $data, ?int $userId = null): TestCase
    {
        $testCase = TestCase::query()->create([
            ...$data,
            'ticket_id' => $ticket->id,
            'proyecto_id' => $data['proyecto_id'] ?? $ticket->proyecto_id,
            'proyecto_modulo_id' => $data['proyecto_modulo_id'] ?? $ticket->proyecto_modulo_id,
            'activo' => $data['activo'] ?? true,
            'created_by_id' => $userId,
            'updated_by_id' => $userId,
        ]);

        $this->history->log($ticket, 'test_case_created', $userId, descripcion: "Caso de prueba creado: {$testCase->titulo}", metadata: ['test_case_id' => $testCase->id]);

        return $testCase;
    }

    public function update(Ticket $ticket, TestCase $testCase, array $data, ?int $userId = null): TestCase
    {
        abort_unless($testCase->ticket_id === $ticket->id, 404);

        $testCase->update([
            ...$data,
            'updated_by_id' => $userId,
        ]);

        $this->history->log($ticket, 'test_case_updated', $userId, descripcion: "Caso de prueba actualizado: {$testCase->titulo}", metadata: ['test_case_id' => $testCase->id]);

        return $testCase;
    }

    public function delete(Ticket $ticket, TestCase $testCase, ?int $userId = null): void
    {
        abort_unless($testCase->ticket_id === $ticket->id, 404);

        $metadata = ['test_case_id' => $testCase->id, 'title' => $testCase->titulo];
        $testCase->delete();

        $this->history->log($ticket, 'test_case_deleted', $userId, descripcion: 'Caso de prueba eliminado.', metadata: $metadata);
    }

    public function generateFromTicket(Ticket $ticket, ?int $userId = null): int
    {
        $ticket->loadMissing('tipo:id,nombre');
        $templates = $this->templatesFor($ticket);
        $created = 0;

        foreach ($templates as $template) {
            $exists = TestCase::query()
                ->where('ticket_id', $ticket->id)
                ->where('titulo', $template['titulo'])
                ->exists();

            if ($exists) {
                continue;
            }

            $this->create($ticket, [
                ...$template,
                'tipo' => $template['tipo'] ?? 'manual',
                'prioridad' => $template['prioridad'] ?? null,
                'activo' => true,
            ], $userId);
            $created++;
        }

        if ($created === 0 && $this->supportWithoutCode($ticket)) {
            $this->setQaStatus($ticket, 'no_requiere', $userId);
        }

        return $created;
    }

    private function templatesFor(Ticket $ticket): array
    {
        $type = mb_strtolower($ticket->tipo?->nombre ?? '');

        if (str_contains($type, 'bug')) {
            return [
                ['titulo' => 'Reproducir el error original', 'pasos' => 'Ejecutar los pasos reportados en el ticket.', 'resultado_esperado' => 'El error se reproduce o queda documentado.', 'tipo' => 'funcional', 'prioridad' => 'alta'],
                ['titulo' => 'Validar correccion del error', 'pasos' => 'Repetir el flujo con la correccion aplicada.', 'resultado_esperado' => 'El error ya no ocurre.', 'tipo' => 'regresion', 'prioridad' => 'alta'],
                ['titulo' => 'Validar flujo principal relacionado', 'pasos' => 'Recorrer el flujo principal afectado.', 'resultado_esperado' => 'El flujo funciona sin regresiones.', 'tipo' => 'regresion'],
                ['titulo' => 'Validar caso borde relacionado', 'pasos' => 'Probar datos o condiciones limite del flujo.', 'resultado_esperado' => 'El sistema responde correctamente.', 'tipo' => 'funcional'],
            ];
        }

        if (str_contains($type, 'mantenimiento')) {
            return [
                ['titulo' => 'Validar cambio solicitado', 'resultado_esperado' => 'El ajuste cumple el alcance solicitado.', 'tipo' => 'funcional'],
                ['titulo' => 'Validar flujo relacionado', 'resultado_esperado' => 'El cambio no afecta funcionalidades cercanas.', 'tipo' => 'regresion'],
                ['titulo' => 'Validacion visual si aplica', 'resultado_esperado' => 'La interfaz se mantiene consistente.', 'tipo' => 'ux'],
            ];
        }

        if (str_contains($type, 'mejora')) {
            return [
                ['titulo' => 'Validar flujo feliz', 'resultado_esperado' => 'La mejora funciona de punta a punta.', 'tipo' => 'funcional'],
                ['titulo' => 'Validar campos requeridos', 'resultado_esperado' => 'Las validaciones esperadas se aplican.', 'tipo' => 'datos'],
                ['titulo' => 'Validar errores esperados', 'resultado_esperado' => 'El sistema muestra errores claros.', 'tipo' => 'funcional'],
                ['titulo' => 'Validar permisos si aplica', 'resultado_esperado' => 'Solo perfiles autorizados pueden usar la mejora.', 'tipo' => 'seguridad'],
            ];
        }

        if (str_contains($type, 'nuevo desarrollo')) {
            return [
                ['titulo' => 'Validar creacion', 'resultado_esperado' => 'El registro se crea correctamente.', 'tipo' => 'funcional'],
                ['titulo' => 'Validar edicion', 'resultado_esperado' => 'Los cambios se guardan correctamente.', 'tipo' => 'funcional'],
                ['titulo' => 'Validar listado', 'resultado_esperado' => 'Los datos aparecen en listados y filtros.', 'tipo' => 'funcional'],
                ['titulo' => 'Validar permisos', 'resultado_esperado' => 'Los permisos protegen acciones sensibles.', 'tipo' => 'seguridad'],
                ['titulo' => 'Validar errores', 'resultado_esperado' => 'Los errores de validacion son claros.', 'tipo' => 'datos'],
                ['titulo' => 'Validar navegacion', 'resultado_esperado' => 'La navegacion es consistente.', 'tipo' => 'ux'],
            ];
        }

        if (str_contains($type, 'incidente')) {
            return [
                ['titulo' => 'Validar recuperacion del servicio', 'resultado_esperado' => 'El servicio critico vuelve a operar.', 'tipo' => 'smoke', 'prioridad' => 'critica'],
                ['titulo' => 'Validar datos afectados', 'resultado_esperado' => 'Los datos se mantienen consistentes.', 'tipo' => 'datos', 'prioridad' => 'alta'],
                ['titulo' => 'Validar flujo critico', 'resultado_esperado' => 'El flujo principal opera correctamente.', 'tipo' => 'funcional', 'prioridad' => 'alta'],
                ['titulo' => 'Validar monitoreo posterior', 'resultado_esperado' => 'No hay alertas posteriores relevantes.', 'tipo' => 'smoke'],
            ];
        }

        return [
            ['titulo' => 'Validar respuesta de soporte', 'resultado_esperado' => 'La respuesta resuelve la solicitud del usuario.', 'tipo' => 'manual'],
        ];
    }

    private function supportWithoutCode(Ticket $ticket): bool
    {
        $type = mb_strtolower($ticket->tipo?->nombre ?? '');

        return str_contains($type, 'soporte')
            && ! $ticket->requires_code_change
            && ! $ticket->has_code_changes;
    }

    private function setQaStatus(Ticket $ticket, string $status, ?int $userId): void
    {
        $old = $ticket->qa_status;
        $ticket->forceFill(['qa_status' => $status])->save();
        $this->history->log($ticket, 'ticket_qa_status_changed', $userId, 'qa_status', $old, $status, "QA marcado como {$status}.");
    }
}
