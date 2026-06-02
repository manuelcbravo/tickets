<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'folio',
        'cliente_id',
        'proyecto_id',
        'proyecto_modulo_id',
        'contacto_id',
        'ambiente_id',
        'creado_por_id',
        'responsable_id',
        'titulo',
        'descripcion',
        'tipo_id',
        'estado_id',
        'prioridad_id',
        'priority_score',
        'triage_notes',
        'missing_information',
        'triage_completed_at',
        'triage_by_id',
        'prioritized_at',
        'prioritized_by_id',
        'impacto_id',
        'urgencia_id',
        'riesgo_id',
        'dificultad',
        'fecha_objetivo',
        'primera_respuesta_at',
        'tiempo_estimado_min',
        'tiempo_real_min',
        'requires_code_change',
        'requires_quote',
        'quote_status',
        'quote_id',
        'external_source',
        'external_reference',
        'billing_warning_acknowledged_at',
        'billing_warning_acknowledged_by_id',
        'is_internal',
        'resolution',
        'development_status',
        'has_code_changes',
        'qa_status',
        'qa_approved_at',
        'qa_approved_by_id',
        'validated_at',
        'validated_by_id',
        'reopen_count',
        'closed_at',
        'closed_by_id',
        'resuelto_at',
        'reopened_at',
        'reopened_by_id',
    ];

    protected $casts = [
        'requires_code_change' => 'boolean',
        'requires_quote' => 'boolean',
        'is_internal' => 'boolean',
        'has_code_changes' => 'boolean',
        'qa_approved_at' => 'datetime',
        'validated_at' => 'datetime',
        'reopen_count' => 'integer',
        'fecha_objetivo' => 'datetime',
        'primera_respuesta_at' => 'datetime',
        'missing_information' => 'array',
        'triage_completed_at' => 'datetime',
        'prioritized_at' => 'datetime',
        'closed_at' => 'datetime',
        'resuelto_at' => 'datetime',
        'reopened_at' => 'datetime',
        'billing_warning_acknowledged_at' => 'datetime',
        'priority_score' => 'integer',
        'tiempo_estimado_min' => 'integer',
        'tiempo_real_min' => 'integer',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(ProyectoModulo::class, 'proyecto_modulo_id');
    }

    public function contacto(): BelongsTo
    {
        return $this->belongsTo(ClienteContacto::class, 'contacto_id');
    }

    public function ambiente(): BelongsTo
    {
        return $this->belongsTo(Ambiente::class, 'ambiente_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por_id');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function cerradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by_id');
    }

    public function reabiertoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reopened_by_id');
    }

    public function triageBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'triage_by_id');
    }

    public function prioritizedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prioritized_by_id');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(CatTicketTipo::class, 'tipo_id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(CatTicketEstado::class, 'estado_id');
    }

    public function prioridad(): BelongsTo
    {
        return $this->belongsTo(CatTicketPrioridad::class, 'prioridad_id');
    }

    public function impacto(): BelongsTo
    {
        return $this->belongsTo(CatTicketImpacto::class, 'impacto_id');
    }

    public function urgencia(): BelongsTo
    {
        return $this->belongsTo(CatTicketUrgencia::class, 'urgencia_id');
    }

    public function riesgo(): BelongsTo
    {
        return $this->belongsTo(CatTicketRiesgo::class, 'riesgo_id');
    }

    public function mensajes(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function adjuntos(): HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function historial(): HasMany
    {
        return $this->hasMany(TicketActivityLog::class)->latest('created_at');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(TicketAssignment::class);
    }

    public function relacionesOrigen(): HasMany
    {
        return $this->hasMany(TicketRelacion::class);
    }

    public function relacionesDestino(): HasMany
    {
        return $this->hasMany(TicketRelacion::class, 'related_ticket_id');
    }

    public function relaciones(): HasMany
    {
        return $this->relacionesOrigen();
    }

    public function checklistItems(): HasMany
    {
        return $this->hasMany(TicketChecklistItem::class)->orderBy('orden')->orderBy('created_at');
    }

    public function tiempos(): HasMany
    {
        return $this->hasMany(TicketTiempo::class);
    }

    public function sla(): HasOne
    {
        return $this->hasOne(TicketSla::class);
    }

    public function knowledgeArticles(): BelongsToMany
    {
        return $this->belongsToMany(KnowledgeArticle::class, 'ticket_knowledge_article')
            ->withPivot(['id', 'tipo_relacion', 'notas', 'created_by_id'])
            ->withTimestamps();
    }

    public function cotizacionPrincipal(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'quote_id');
    }

    public function cotizaciones(): BelongsToMany
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_tickets')
            ->withPivot(['id', 'tipo_relacion', 'created_by_id'])
            ->withTimestamps();
    }

    public function webhookEvents(): HasMany
    {
        return $this->hasMany(WebhookEvent::class);
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }

    public function externalMessages(): HasMany
    {
        return $this->hasMany(ExternalMessage::class);
    }

    public function aiAnalyses(): HasMany
    {
        return $this->hasMany(AiAnalysis::class)->latest();
    }

    public function aiActions(): HasMany
    {
        return $this->hasMany(AiAction::class)->latest();
    }

    public function developmentTasks(): HasMany
    {
        return $this->hasMany(TicketDevelopmentTask::class);
    }

    public function proyectoActividades(): BelongsToMany
    {
        return $this->belongsToMany(ProyectoActividad::class, 'proyecto_actividad_tickets', 'ticket_id', 'actividad_id')
            ->withPivot(['id', 'tipo_relacion', 'created_by_id'])
            ->withTimestamps();
    }

    public function actividadLinks(): HasMany
    {
        return $this->hasMany(ProyectoActividadTicket::class);
    }

    public function developmentLinks(): HasMany
    {
        return $this->hasMany(TicketDevelopmentLink::class);
    }

    public function releases(): BelongsToMany
    {
        return $this->belongsToMany(Release::class, 'release_tickets')
            ->withPivot(['id', 'development_task_id', 'notas', 'created_by_id'])
            ->withTimestamps();
    }

    public function testCases(): HasMany
    {
        return $this->hasMany(TestCase::class);
    }

    public function testResults(): HasMany
    {
        return $this->hasMany(TicketTestResult::class);
    }

    public function testEvidences(): HasMany
    {
        return $this->hasMany(TicketTestEvidence::class);
    }

    public function validations(): HasMany
    {
        return $this->hasMany(TicketValidation::class);
    }

    public function reopenLogs(): HasMany
    {
        return $this->hasMany(TicketReopenLog::class)->latest();
    }

    public function qaApprovedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'qa_approved_by_id');
    }

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by_id');
    }

    public function billingWarningAcknowledgedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'billing_warning_acknowledged_by_id');
    }
}
