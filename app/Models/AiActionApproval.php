<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiActionApproval extends Model
{
    use HasUuid;

    protected $fillable = [
        'ai_action_id',
        'requested_by_id',
        'approved_by_id',
        'status',
        'notes',
    ];

    public function action(): BelongsTo
    {
        return $this->belongsTo(AiAction::class, 'ai_action_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }
}
