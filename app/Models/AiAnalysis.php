<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiAnalysis extends Model
{
    use HasUuid;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'model',
        'status',
        'analysis_type',
        'summary',
        'detected_problem',
        'suggested_type_id',
        'suggested_priority_id',
        'suggested_impact_id',
        'suggested_urgency_id',
        'suggested_risk_id',
        'suggested_difficulty',
        'missing_information',
        'suggested_reply',
        'suggested_checklist',
        'can_answer_directly',
        'requires_code_change',
        'requires_quote',
        'confidence',
        'prompt',
        'raw_response',
        'error_message',
        'executed_at',
    ];

    protected $casts = [
        'missing_information' => 'array',
        'suggested_checklist' => 'array',
        'raw_response' => 'array',
        'can_answer_directly' => 'boolean',
        'requires_code_change' => 'boolean',
        'requires_quote' => 'boolean',
        'confidence' => 'decimal:2',
        'executed_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function suggestedType(): BelongsTo
    {
        return $this->belongsTo(CatTicketTipo::class, 'suggested_type_id');
    }

    public function suggestedPriority(): BelongsTo
    {
        return $this->belongsTo(CatTicketPrioridad::class, 'suggested_priority_id');
    }

    public function suggestedImpact(): BelongsTo
    {
        return $this->belongsTo(CatTicketImpacto::class, 'suggested_impact_id');
    }

    public function suggestedUrgency(): BelongsTo
    {
        return $this->belongsTo(CatTicketUrgencia::class, 'suggested_urgency_id');
    }

    public function suggestedRisk(): BelongsTo
    {
        return $this->belongsTo(CatTicketRiesgo::class, 'suggested_risk_id');
    }

    public function actions(): HasMany
    {
        return $this->hasMany(AiAction::class);
    }
}
