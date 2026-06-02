<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiAction extends Model
{
    use HasUuid;

    protected $fillable = [
        'ticket_id',
        'ai_analysis_id',
        'user_id',
        'type',
        'status',
        'title',
        'prompt',
        'response',
        'metadata',
        'applied_by_id',
        'applied_at',
        'rejected_by_id',
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'metadata' => 'array',
        'applied_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function analysis(): BelongsTo
    {
        return $this->belongsTo(AiAnalysis::class, 'ai_analysis_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applied_by_id');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(AiActionApproval::class);
    }
}
